<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;
    
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'published_date', 
        'category_id', 'image_url', 'author', 'is_published', 'news_image_upload', 'is_featured', 'gallery_uploads'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected $casts = [
        'published_date'  => 'date',
        'is_published'    => 'boolean',
        'is_featured'     => 'boolean',
        'gallery_uploads' => 'array',
    ];
    
    public static function boot()
    {
        parent::boot();
        static::saving(function ($news) {
            if (empty($news->slug)) {
                $news->slug = \Illuminate\Support\Str::slug($news->title) . '-' . rand(100, 999);
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news_image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function getDisplayImageAttribute(): string
    {
        // 1. Priority: Spatie Media
        if ($this->hasMedia('news_image')) {
            return cdn_rewrite($this->getFirstMediaUrl('news_image'));
        }

        // 2. Secondary: Explicit Database Fields
        $dbPath = $this->news_image_upload ?: $this->image_url;
        if ($dbPath) {
            if (str_starts_with($dbPath, 'http')) return $dbPath;
            $cleanPath = ltrim($dbPath, '/');

            // Check if it's already in public/images/
            if (file_exists(public_path('images/' . basename($cleanPath)))) {
                return asset('images/' . basename($cleanPath));
            }
            if (file_exists(public_path('img/images/' . basename($cleanPath)))) {
                return asset('img/images/' . basename($cleanPath));
            }

            if ($cdn = config('app.image_cdn_url')) {
                return rtrim($cdn, '/') . '/' . ltrim($cleanPath, '/');
            }

            if (str_contains($cleanPath, 'storage/')) return asset($cleanPath);
            return asset('storage/' . $cleanPath);
        }

        // 3. Fallback
        return 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop';
    }
}
