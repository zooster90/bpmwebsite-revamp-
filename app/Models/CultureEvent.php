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
     * Detection map for Malaysian universities / polytechnics / colleges.
     * Used to auto-render the institution's brand logo next to the intern's
     * university name on the public cohort card. Detection runs against
     * the lowercase `university` field — any alias that appears as a
     * substring is a match.
     *
     * `short` is used as both the logo filename (e.g. usm -> usm.png) AND
     * the text shown on the styled abbreviation badge that displays when
     * the actual logo file hasn't been uploaded yet.
     */
    public const UNIVERSITY_BRANDS = [
        // ── Public Research Universities ─────────────────────────────
        'usm'    => ['name' => 'Universiti Sains Malaysia',          'short' => 'USM',    'aliases' => ['usm', 'universiti sains malaysia', 'sains malaysia']],
        'um'     => ['name' => 'Universiti Malaya',                  'short' => 'UM',     'aliases' => ['universiti malaya', 'university of malaya', 'universiti of malaya']],
        'utm'    => ['name' => 'Universiti Teknologi Malaysia',      'short' => 'UTM',    'aliases' => ['utm', 'universiti teknologi malaysia', 'teknologi malaysia']],
        'ukm'    => ['name' => 'Universiti Kebangsaan Malaysia',     'short' => 'UKM',    'aliases' => ['ukm', 'universiti kebangsaan malaysia', 'kebangsaan malaysia', 'national university']],
        'upm'    => ['name' => 'Universiti Putra Malaysia',          'short' => 'UPM',    'aliases' => ['upm', 'universiti putra malaysia', 'putra malaysia']],
        // ── State / Specialised Public Universities ──────────────────
        'uitm'   => ['name' => 'Universiti Teknologi MARA',          'short' => 'UiTM',   'aliases' => ['uitm', 'teknologi mara', 'universiti teknologi mara']],
        'iium'   => ['name' => 'International Islamic University',   'short' => 'IIUM',   'aliases' => ['iium', 'international islamic university', 'islamic university malaysia']],
        'uthm'   => ['name' => 'Universiti Tun Hussein Onn',         'short' => 'UTHM',   'aliases' => ['uthm', 'tun hussein onn']],
        'unimap' => ['name' => 'Universiti Malaysia Perlis',         'short' => 'UniMAP', 'aliases' => ['unimap', 'malaysia perlis']],
        'umt'    => ['name' => 'Universiti Malaysia Terengganu',     'short' => 'UMT',    'aliases' => ['malaysia terengganu']],
        'ums'    => ['name' => 'Universiti Malaysia Sabah',          'short' => 'UMS',    'aliases' => ['malaysia sabah']],
        'umk'    => ['name' => 'Universiti Malaysia Kelantan',       'short' => 'UMK',    'aliases' => ['malaysia kelantan']],
        'ump'    => ['name' => 'Universiti Malaysia Pahang',         'short' => 'UMP',    'aliases' => ['malaysia pahang']],
        'usim'   => ['name' => 'Universiti Sains Islam Malaysia',    'short' => 'USIM',   'aliases' => ['usim', 'sains islam malaysia']],
        'upsi'   => ['name' => 'Universiti Pendidikan Sultan Idris', 'short' => 'UPSI',   'aliases' => ['upsi', 'sultan idris']],
        'utar'   => ['name' => 'Universiti Tunku Abdul Rahman',      'short' => 'UTAR',   'aliases' => ['utar', 'tunku abdul rahman']],
        // ── Private Universities ─────────────────────────────────────
        'taylors'=> ['name' => "Taylor's University",                'short' => "Taylor's",'aliases' => ["taylor's", 'taylors university']],
        'sunway' => ['name' => 'Sunway University',                  'short' => 'Sunway', 'aliases' => ['sunway university']],
        'monash' => ['name' => 'Monash University Malaysia',         'short' => 'Monash', 'aliases' => ['monash']],
        'inti'   => ['name' => 'INTI International University',      'short' => 'INTI',   'aliases' => ['inti international', 'inti university']],
        'help'   => ['name' => 'HELP University',                    'short' => 'HELP',   'aliases' => ['help university']],
        'ucsi'   => ['name' => 'UCSI University',                    'short' => 'UCSI',   'aliases' => ['ucsi']],
        'mmu'    => ['name' => 'Multimedia University',              'short' => 'MMU',    'aliases' => ['multimedia university']],
        'apu'    => ['name' => 'Asia Pacific University',            'short' => 'APU',    'aliases' => ['asia pacific university']],
        'curtin' => ['name' => 'Curtin University Malaysia',         'short' => 'Curtin', 'aliases' => ['curtin']],
        'nottingham' => ['name' => 'University of Nottingham Malaysia', 'short' => 'UoN', 'aliases' => ['nottingham']],
        // ── Polytechnics ─────────────────────────────────────────────
        'psp'    => ['name' => 'Politeknik Seberang Perai',          'short' => 'PSP',    'aliases' => ['politeknik seberang perai', 'seberang perai']],
        'puo'    => ['name' => 'Politeknik Ungku Omar',              'short' => 'PUO',    'aliases' => ['ungku omar']],
        'pmu'    => ['name' => 'Politeknik Mukah',                   'short' => 'PMU',    'aliases' => ['politeknik mukah']],
        'ptsb'   => ['name' => 'Politeknik Tuanku Sultanah Bahiyah', 'short' => 'PTSB',   'aliases' => ['ptsb', 'sultanah bahiyah']],
        'psas'   => ['name' => 'Politeknik Sultan Azlan Shah',       'short' => 'PSAS',   'aliases' => ['psas', 'azlan shah']],
        'pis'    => ['name' => 'Politeknik Ibrahim Sultan',          'short' => 'PIS',    'aliases' => ['ibrahim sultan']],
        'psa'    => ['name' => 'Politeknik Sultan Salahuddin Abdul Aziz Shah', 'short' => 'PSA', 'aliases' => ['salahuddin abdul aziz']],
        // ── MARA / Vocational Colleges ───────────────────────────────
        'kptm'   => ['name' => 'Kolej Poli-Tech MARA',               'short' => 'KPTM',   'aliases' => ['kptm', 'poli-tech mara', 'kolej polytech mara', 'kolej poli tech mara']],
        'gmi'    => ['name' => 'German-Malaysian Institute',         'short' => 'GMI',    'aliases' => ['german-malaysian', 'german malaysian institute']],
        'kkkk'   => ['name' => 'Kolej Komuniti',                     'short' => 'KK',     'aliases' => ['kolej komuniti']],
    ];

    /**
     * Try to map the free-text `university` field to a known brand slug.
     * Returns null if no alias matches.
     */
    public function getUniversitySlugAttribute(): ?string
    {
        if (empty($this->university)) {
            return null;
        }

        $needle = strtolower(trim($this->university));

        foreach (self::UNIVERSITY_BRANDS as $slug => $brand) {
            foreach ($brand['aliases'] as $alias) {
                if (str_contains($needle, strtolower($alias))) {
                    return $slug;
                }
            }
        }

        return null;
    }

    /**
     * Resolve the actual brand logo URL for this intern's university,
     * IF a logo image file exists under public/img/university-logos/{slug}.png.
     * Result is cached for a day so we don't hit the filesystem on every
     * render (the intern grid can be 10+ cards per cohort).
     *
     * Returns null when:
     *   - the university text doesn't map to any known brand, OR
     *   - the logo file hasn't been uploaded yet (admin can drop logos
     *     into public/img/university-logos/ to enable real branding).
     * The view falls back to a styled abbreviation badge in that case.
     */
    public function getUniversityLogoUrlAttribute(): ?string
    {
        $slug = $this->university_slug;
        if (! $slug) {
            return null;
        }

        return \Illuminate\Support\Facades\Cache::remember(
            "uni-logo-{$slug}",
            now()->addDay(),
            function () use ($slug) {
                foreach (['svg', 'png', 'webp', 'jpg', 'jpeg'] as $ext) {
                    $relative = "img/university-logos/{$slug}.{$ext}";
                    if (file_exists(public_path($relative))) {
                        return asset($relative);
                    }
                }
                return null;
            }
        );
    }

    /**
     * Short abbreviation to render as a fallback badge when no logo file
     * is uploaded (USM, UM, UTM, etc.). Returns null if the university
     * text doesn't match any known brand.
     */
    public function getUniversityShortAttribute(): ?string
    {
        $slug = $this->university_slug;
        return $slug ? self::UNIVERSITY_BRANDS[$slug]['short'] ?? null : null;
    }

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
