<?php

namespace App\Observers;

use App\Services\ImageCompressionService;

/**
 * ╔══════════════════════════════════════════════════════════════════════╗
 * ║   ImageCompressionObserver                                           ║
 * ║   ─────────────────────────────────────────────────────────────────  ║
 * ║   Universal model observer that auto-compresses images on save.     ║
 * ║   Attach this to any model that has image upload fields.            ║
 * ║                                                                      ║
 * ║   Usage (in AppServiceProvider::boot):                              ║
 * ║   Project::observe(ImageCompressionObserver::class);                ║
 * ╚══════════════════════════════════════════════════════════════════════╝
 */
class ImageCompressionObserver
{
    protected ImageCompressionService $compressor;

    public function __construct(ImageCompressionService $compressor)
    {
        $this->compressor = $compressor;
    }

    /**
     * Fires after a record is first created.
     * Compresses all image fields immediately after upload.
     */
    public function created(mixed $model): void
    {
        $this->handleCompression($model);
    }

    /**
     * Fires after a record is updated (e.g., new image uploaded via Filament Edit).
     */
    public function updated(mixed $model): void
    {
        $this->handleCompression($model);
    }

    /**
     * Inspect the model for known image upload fields and compress them.
     * Fields are determined dynamically — works for any model.
     */
    protected function handleCompression(mixed $model): void
    {
        $disk = 'public';

        // ── Single image upload fields ──────────────────────────────────
        $singleFields = [
            'cover_image_upload',   // Project
            'culture_image_upload', // CultureEvent
            'logo_upload',          // Award
            'press_image_upload',   // PressCoverage
            'news_image_upload',    // News
        ];

        foreach ($singleFields as $field) {
            if (isset($model->{$field}) && ! empty($model->{$field})) {
                $this->compressor->compress($model->{$field}, $disk);
            }
        }

        // ── Multi-image gallery fields (stored as JSON array) ───────────
        $galleryFields = ['gallery_uploads'];

        foreach ($galleryFields as $field) {
            if (isset($model->{$field}) && is_array($model->{$field})) {
                $this->compressor->compressMany($model->{$field}, $disk);
            }
        }
    }
}
