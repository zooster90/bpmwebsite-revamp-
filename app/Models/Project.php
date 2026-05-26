<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'name', 'slug', 'description', 'client', 'location',
        'category_id', 'status', 'year', 'is_flagship', 'is_published',
        'sort_order', 'image_url', 'contract_value', 'client',
        'cover_image_upload', 'gallery_uploads', 'award',
    ];

    protected $casts = [
        'is_flagship'     => 'boolean',
        'is_published'    => 'boolean',
        'year'            => 'integer',
        'sort_order'      => 'integer',
        'gallery_uploads' => 'array',
    ];
    
    public static function boot()
    {
        parent::boot();
        static::saving(function ($project) {
            if (empty($project->slug)) {
                $project->slug = \Illuminate\Support\Str::slug($project->name) . '-' . rand(100, 999);
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_image')->useDisk('public')->singleFile();
        $this->addMediaCollection('gallery')->useDisk('public');
    }

    public function awards()
    {
        return $this->hasMany(Award::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getDisplayImageAttribute(): string
    {
        if ($this->hasMedia('cover_image')) {
            $url = cdn_rewrite($this->getFirstMediaUrl('cover_image'));
            if ($url) return $url;
        }

        $path = $this->cover_image_upload ?: $this->image_url;
        if (!$path) {
            return 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1200&auto=format&fit=crop';
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) return $path;

        $clean = ltrim($path, '/');
        if (str_starts_with($clean, 'public/')) $clean = substr($clean, 7);

        $filename = basename($clean);
        if (file_exists(public_path('images/' . $filename))) return asset('images/' . $filename);
        if (file_exists(public_path('img/images/' . $filename))) return asset('img/images/' . $filename);

        if ($cdn = config('app.image_cdn_url')) {
            return rtrim($cdn, '/') . '/' . ltrim($clean, '/');
        }

        return str_contains($clean, 'storage/') ? asset($clean) : asset('storage/' . $clean);
    }
}
