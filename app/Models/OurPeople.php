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
        $this->addMediaCollection('people_image')->useDisk('public')->singleFile();
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
