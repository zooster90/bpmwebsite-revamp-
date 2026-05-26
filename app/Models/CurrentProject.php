<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * CurrentProject — Active / Featured Ongoing Projects
 *
 * These are the high-priority ongoing projects shown on the
 * homepage and in prominent "What We Are Building Now" sections.
 * Separate from the full historical Project archive.
 */
class CurrentProject extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'title', 'slug', 'location', 'category_id', 'status',
        'description', 'image_url', 'client', 'year',
        'contract_value', 'is_active', 'sort_order',
        'image_upload', 'gallery_uploads',
        'completion_percentage',
    ];

    protected $casts = [
        'is_active'             => 'boolean',
        'year'                  => 'integer',
        'sort_order'            => 'integer',
        'gallery_uploads'       => 'array',
        'completion_percentage' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_image')->useDisk('public')->singleFile();
        $this->addMediaCollection('gallery')->useDisk('public');
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(400)->format('webp')->quality(72)->nonQueued();
        $this->addMediaConversion('card')->width(800)->format('webp')->quality(78)->nonQueued();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getDisplayImageAttribute(): string
    {
        if ($this->hasMedia('cover_image')) {
            return cdn_rewrite($this->getFirstMediaUrl('cover_image'));
        }

        $dbPath = $this->image_upload ?: $this->image_url;
        if ($dbPath) {
            if (str_starts_with($dbPath, 'http')) return $dbPath;
            $cleanPath = ltrim($dbPath, '/');
            
            if (file_exists(public_path('images/' . basename($cleanPath)))) {
                return asset('images/' . basename($cleanPath));
            }
            if (file_exists(public_path('img/images/' . basename($cleanPath)))) {
                return asset('img/images/' . basename($cleanPath));
            }

            if ($cdn = config('app.image_cdn_url')) {
                return rtrim($cdn, '/') . '/' . ltrim($cleanPath, '/');
            }

            return str_contains($cleanPath, 'storage/') ? asset($cleanPath) : asset('storage/' . $cleanPath);
        }

        return 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1200';
    }
}
