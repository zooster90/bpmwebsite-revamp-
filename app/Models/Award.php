<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Award extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $fillable = ['name', 'issuer', 'year', 'description', 'category_id', 'image_url', 'logo_upload', 'gallery_uploads', 'project_id'];

    protected $casts = [
        'year'            => 'integer',
        'gallery_uploads' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function registerMediaCollections(): void
    {
        // "logo" — the award organization's logo image
        $this->addMediaCollection('logo')->singleFile();
        // "gallery" — award certificates or ceremony photos
        $this->addMediaCollection('gallery');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getDisplayImageAttribute(): string
    {
        // 1. Priority: Spatie Media
        if ($this->hasMedia('logo')) {
            return $this->getFirstMediaUrl('logo');
        }

        // 2. Secondary: Explicit Database Fields
        $dbPath = $this->logo_upload ?: $this->image_url;
        if ($dbPath) {
            if (str_starts_with($dbPath, 'http')) return $dbPath;
            $cleanPath = ltrim($dbPath, '/');
            
            if (file_exists(public_path('images/' . basename($cleanPath)))) {
                return asset('images/' . rawurlencode(basename($cleanPath)));
            }
            if (file_exists(public_path('img/images/' . basename($cleanPath)))) {
                return asset('img/images/' . rawurlencode(basename($cleanPath)));
            }

            if (str_contains($cleanPath, 'storage/')) return asset($cleanPath);
            return asset('storage/' . $cleanPath);
        }

        // 3. Category-based Smart Fallback
        $logoMap = [
            'cidb'     => 'cidb_logo-768x250.png',
            'shassic'  => 'shassic_logo-removebg-preview.png',
            'gbi'      => 'GBI logo ..png',
            'qlassic'  => 'qlassic.jpg', // Switched to a safer filename
            'iso'      => 'ISO_14001_Latest.jpg',
            'quality'  => 'SGS_ISO 9001 - DSM Mark_TCL_LR.jpg',
            'safety'   => 'MSOSH Logo.jpg',
            'business' => 'SME .png',
        ];

        $catKey = strtolower(trim($this->category?->name ?? ''));
        if (isset($logoMap[$catKey])) {
            $fileName = $logoMap[$catKey];
            // Use rawurlencode to handle spaces and dots in filenames
            return asset('images/' . str_replace('%2F', '/', rawurlencode($fileName)));
        }

        // 4. Final Fallback
        return 'https://images.unsplash.com/photo-1579541814924-49fef17c5be5?q=80&w=2070&auto=format&fit=crop';
    }
}
