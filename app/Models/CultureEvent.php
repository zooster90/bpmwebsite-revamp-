<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CultureEvent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;
    
    protected $fillable = [
        'title', 'slug', 'event_date', 'description', 
        'image_url', 'year', 'name', 'category_id', 'sub_category_id', 'culture_image_upload', 'gallery_uploads', 'video_url', 'video_upload',
        // Internship-specific fields
        'intern_name', 'university', 'department', 'intern_period',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    protected $casts = [
        'event_date' => 'date',
        'year'            => 'integer',
        'gallery_uploads' => 'array',
    ];

    /**
     * Scope to get all internship events grouped by year.
     * Returns collection keyed by year, each containing all intern events.
     */
    public static function getInternsByYear(): \Illuminate\Support\Collection
    {
        return static::whereHas('category', function ($q) {
                $q->whereIn('slug', ['intern', 'internship']);
            })
            ->orderBy('year', 'desc')
            ->orderBy('event_date', 'desc')
            ->get()
            ->groupBy(fn ($e) => $e->year ?? ($e->event_date ? $e->event_date->year : 'Unknown'));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('culture_image')->useDisk('public')->singleFile();
        $this->addMediaCollection('gallery')->useDisk('public');
    }

    public function getDisplayImageAttribute(): string
    {
        // 1. Priority: Spatie Media
        if ($this->hasMedia('culture_image')) {
            return $this->getFirstMediaUrl('culture_image');
        }

        // 2. Secondary: Explicit Database Fields
        $dbPath = $this->culture_image_upload ?: $this->image_url;
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

            if (str_contains($cleanPath, 'storage/')) return asset($cleanPath);
            return asset('storage/' . $cleanPath);
        }

        // 3. Category-based Fallbacks
        $fallbacks = [
            'team_building' => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=800&q=80',
            'internship'    => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800&q=80',
            'csr'           => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&q=80',
            'festive'       => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80',
            'trip'          => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80',
            'work'          => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80',
            'awards'        => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&q=80',
            'sports'        => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=800&q=80',
            'anniversary'   => 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=800&q=80',
            'family_day'    => 'https://images.unsplash.com/photo-1491438590914-bc09fcaaf77a?w=800&q=80',
            'safety'        => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&q=80',
        ];

        $cat = strtolower(trim($this->category?->slug ?? ''));
        if (isset($fallbacks[$cat])) {
            return $fallbacks[$cat];
        }

        // 4. Final Fallback
        return 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=2070&auto=format&fit=crop';
    }
}
