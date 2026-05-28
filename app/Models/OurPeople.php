<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OurPeople extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        // 'people_image' — the primary photo (still single file, used as cover).
        $this->addMediaCollection('people_image')->useDisk('public')->singleFile();

        // 'gallery' — additional team photos. Admin can upload multiple,
        // drag to reorder. Shown as a carousel on the public team page.
        $this->addMediaCollection('gallery')->useDisk('public');
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(400)->format('webp')->quality(72)->nonQueued();
        $this->addMediaConversion('card')->width(800)->format('webp')->quality(78)->nonQueued();
    }

    public function getDisplayImageAttribute()
    {
        if ($this->hasMedia('people_image')) {
            return cdn_rewrite($this->getFirstMediaUrl('people_image'));
        }
        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            $cleanPath = ltrim($this->image, '/');
            if (file_exists(public_path($cleanPath))) {
                return asset($cleanPath);
            }
            if (file_exists(public_path('images/' . basename($cleanPath)))) {
                return asset('images/' . basename($cleanPath));
            }
            if (file_exists(public_path('img/images/' . basename($cleanPath)))) {
                return asset('img/images/' . basename($cleanPath));
            }
            if ($cdn = config('app.image_cdn_url')) {
                return rtrim($cdn, '/') . '/' . ltrim($cleanPath, '/');
            }
            if (str_contains($cleanPath, 'storage/')) {
                return asset($cleanPath);
            }
            return asset('storage/' . $cleanPath);
        }
        return null;
    }
}
