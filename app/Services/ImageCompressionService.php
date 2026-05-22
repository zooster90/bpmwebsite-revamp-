<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * ╔══════════════════════════════════════════════════════════════════════╗
 * ║   ImageCompressionService                                            ║
 * ║   ─────────────────────────────────────────────────────────────────  ║
 * ║   Compresses uploaded images to WebP format automatically.           ║
 * ║   • Outputs: HD quality (85%) WebP — best size/quality ratio        ║
 * ║   • Preserves original path/filename (just changes content)         ║
 * ║   • Resizes only if image exceeds max dimensions (non-destructive)  ║
 * ║   • Uses intervention/image v4 (already installed in composer.json) ║
 * ╚══════════════════════════════════════════════════════════════════════╝
 */
class ImageCompressionService
{
    /**
     * Maximum width/height in pixels before downscaling kicks in.
     * 1920px = Full HD — perfect for web display.
     */
    protected int $maxWidth  = 1920;
    protected int $maxHeight = 1920;

    /**
     * WebP quality: 85 = excellent HD quality, ~60-70% smaller than raw JPG/PNG.
     */
    protected int $quality = 85;

    /**
     * Compress and optionally resize a single uploaded file on the 'public' disk.
     *
     * @param  string|null  $relativePath  e.g. "project-covers/filename.jpg"
     * @param  string       $disk          Storage disk name (default: 'public')
     * @return void
     */
    public function compress(?string $relativePath, string $disk = 'public'): void
    {
        if (empty($relativePath)) {
            return;
        }

        try {
            $storage  = Storage::disk($disk);

            if (! $storage->exists($relativePath)) {
                return;
            }

            $absolutePath = $storage->path($relativePath);
            $extension    = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));

            // Only process image files — skip PDFs, videos, etc.
            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'])) {
                return;
            }

            // Create the Intervention Image manager with GD driver (no extra deps)
            $manager = new ImageManager(new Driver());
            $image   = $manager->read($absolutePath);

            // Scale down only if image exceeds max dimensions (never upscale)
            if ($image->width() > $this->maxWidth || $image->height() > $this->maxHeight) {
                $image->scaleDown($this->maxWidth, $this->maxHeight);
            }

            // Encode to WebP at HD quality and overwrite the original file
            $image->toWebp($this->quality)->save($absolutePath);

            Log::info("[ImageCompression] Compressed: {$relativePath}");

        } catch (\Throwable $e) {
            // Never crash the app over an image — just log and continue
            Log::warning("[ImageCompression] Failed for {$relativePath}: " . $e->getMessage());
        }
    }

    /**
     * Compress an array of gallery image paths (gallery_uploads JSON field).
     *
     * @param  array|null  $paths   Array of relative paths
     * @param  string      $disk
     * @return void
     */
    public function compressMany(?array $paths, string $disk = 'public'): void
    {
        if (empty($paths)) {
            return;
        }

        foreach ($paths as $path) {
            $this->compress($path, $disk);
        }
    }
}
