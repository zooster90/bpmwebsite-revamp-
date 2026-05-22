<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PressCoverage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;
    
    protected $fillable = [
        'headline', 'publication', 'published_date', 
        'external_url', 'excerpt', 'image_url',
        'press_image_upload', 'gallery_uploads', 'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected $casts = [
        'published_date'  => 'date',
        'gallery_uploads' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('press_image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function getDisplayImageAttribute(): string
    {
        // 1. Priority: Spatie Media
        if ($this->hasMedia('press_image')) {
            return cdn_rewrite($this->getFirstMediaUrl('press_image'));
        }

        // 2. Secondary: Explicit Database Fields
        $dbPath = $this->press_image_upload ?: $this->image_url;
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
        return 'https://images.unsplash.com/photo-1585829365234-754eb4506119?q=80&w=2070&auto=format&fit=crop';
    }
}

