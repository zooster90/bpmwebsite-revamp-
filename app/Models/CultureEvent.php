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
        'title', 'slug', 'event_date', 'description', 'is_published',
        'image_url', 'year', 'name', 'category_id', 'sub_category_id', 'culture_image_upload', 'gallery_uploads', 'video_url', 'video_upload',
        // Internship-specific fields
        'intern_name', 'university', 'institution_type', 'department', 'intern_type', 'intern_period',
    ];

    /**
     * Two intern placement buckets shown as separate sections on the
     * public cohort page. Records left null (e.g. a cohort group photo)
     * appear in the "Cohort Highlights" strip and are NOT counted as
     * actual interns in the Total Interns badge.
     */
    public const INTERN_TYPES = [
        'site'   => ['label' => 'Site Intern',   'icon' => 'fa-solid fa-helmet-safety', 'description' => 'Placed on a live construction site (e.g. Pantai Hospital, PHP, GHP, BSP).'],
        'office' => ['label' => 'Office Intern', 'icon' => 'fa-solid fa-building',      'description' => 'Placed at HQ / corporate office.'],
    ];

    /**
     * Map of institution_type keys to the Font Awesome icon + human label.
     * Admin picks one of these on the form so the public card renders an
     * appropriate icon next to the institution name (e.g. school logo for
     * schools, helmet for construction site placements, etc.).
     */
    public const INSTITUTION_TYPES = [
        'university'       => ['label' => 'University',        'icon' => 'fa-solid fa-university'],
        'polytechnic'      => ['label' => 'Polytechnic',       'icon' => 'fa-solid fa-flask'],
        'college'          => ['label' => 'College',           'icon' => 'fa-solid fa-graduation-cap'],
        'school'           => ['label' => 'School',            'icon' => 'fa-solid fa-school'],
        'training_center'  => ['label' => 'Training Centre',   'icon' => 'fa-solid fa-chalkboard-user'],
        'site'             => ['label' => 'Construction Site', 'icon' => 'fa-solid fa-helmet-safety'],
        'office'           => ['label' => 'Office / Corporate','icon' => 'fa-solid fa-building'],
        'engineering_firm' => ['label' => 'Engineering Firm',  'icon' => 'fa-solid fa-gears'],
    ];

    public function getInstitutionIconAttribute(): string
    {
        $key = $this->institution_type ?: 'university';
        return self::INSTITUTION_TYPES[$key]['icon'] ?? self::INSTITUTION_TYPES['university']['icon'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    protected $casts = [
        'event_date'      => 'date',
        'year'            => 'integer',
        'gallery_uploads' => 'array',
        'is_published'    => 'boolean',
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

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->format('webp')
            ->quality(72)
            ->nonQueued();

        $this->addMediaConversion('card')
            ->width(800)
            ->format('webp')
            ->quality(78)
            ->nonQueued();
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
