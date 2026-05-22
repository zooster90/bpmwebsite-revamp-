<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Project;
use App\Models\News;
use App\Models\Award;
use App\Models\CultureEvent;
use App\Models\Press;

class ImportSupabaseImages extends Command
{
    protected $signature = 'import:supabase-images
                            {--table=all : Which table to import (all|projects|news|culture|awards|media)}
                            {--skip-download : Skip downloading images, only update DB paths}
                            {--dry-run : Show what would be done without doing it}';

    protected $description = 'Download all Supabase images to local storage and update database records';

    private int $downloaded = 0;
    private int $failed = 0;
    private int $skipped = 0;

    public function handle(): int
    {
        $table = $this->option('table');
        $skipDownload = $this->option('skip-download');
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE — no changes will be made');
        }

        $this->info('');
        $this->info('╔══════════════════════════════════════════════╗');
        $this->info('║   BUILTECH — Supabase Image Migration Tool   ║');
        $this->info('╚══════════════════════════════════════════════╝');
        $this->info('');

        // Ensure storage directories exist
        foreach (['projects', 'news', 'culture', 'awards', 'press'] as $dir) {
            Storage::disk('public')->makeDirectory("supabase/$dir");
        }

        // Run imports
        if ($table === 'all' || $table === 'projects') {
            $this->importProjects($skipDownload, $dryRun);
        }
        if ($table === 'all' || $table === 'news') {
            $this->importNews($skipDownload, $dryRun);
        }
        if ($table === 'all' || $table === 'culture') {
            $this->importCulture($skipDownload, $dryRun);
        }
        if ($table === 'all' || $table === 'awards') {
            $this->importAwards($skipDownload, $dryRun);
        }
        if ($table === 'all' || $table === 'media') {
            $this->importMedia($skipDownload, $dryRun);
        }

        $this->info('');
        $this->info('╔══════════════════════════════════════════════╗');
        $this->info("║  ✅ Downloaded: {$this->downloaded}");
        $this->info("║  ⏭  Skipped:    {$this->skipped} (already local)");
        $this->info("║  ❌ Failed:     {$this->failed}");
        $this->info('╚══════════════════════════════════════════════╝');

        return 0;
    }

    // ──────────────────────────────────────────────
    // PROJECTS
    // ──────────────────────────────────────────────
    private function importProjects(bool $skipDownload, bool $dryRun): void
    {
        $this->info('📁 Processing PROJECTS...');

        $data = $this->loadJson('database/data/projects.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $item) {
            $slug = Str::slug($item['title'] ?? 'project-' . $item['id']);
            $project = Project::where('slug', $slug)->first();

            if (!$project) {
                $bar->advance();
                continue;
            }

            $imgs = is_array($item['img']) ? $item['img'] : [];
            $supabaseUrls = array_values(array_filter($imgs, fn($u) => str_contains($u, 'supabase')));

            if (empty($supabaseUrls)) {
                $bar->advance();
                continue;
            }

            $localPaths = [];
            foreach ($supabaseUrls as $i => $url) {
                $localPath = $this->downloadImage($url, 'projects', $skipDownload, $dryRun);
                if ($localPath) {
                    $localPaths[] = $localPath;
                }
            }

            if (!empty($localPaths) && !$dryRun) {
                // Set primary image_url to first image
                $project->update([
                    'image_url'  => Storage::disk('public')->url($localPaths[0]),
                    'gallery'    => json_encode(array_map(
                        fn($p) => Storage::disk('public')->url($p),
                        $localPaths
                    )),
                ]);

                // Register with Spatie Media Library
                $this->registerMediaForProject($project, $localPaths);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  ✅ Projects processed\n");
    }

    // ──────────────────────────────────────────────
    // NEWS
    // ──────────────────────────────────────────────
    private function importNews(bool $skipDownload, bool $dryRun): void
    {
        $this->info('📰 Processing NEWS...');

        $data = $this->loadJson('database/data/news.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $item) {
            $imgs = is_array($item['img']) ? $item['img'] : [];
            $supabaseUrls = array_values(array_filter($imgs, fn($u) => is_string($u) && str_contains($u, 'supabase')));

            if (empty($supabaseUrls)) {
                $bar->advance();
                continue;
            }

            // Find by title
            $title = $item['title'] ?? '';
            $news = News::where('title', $title)->first();

            if (!$news) {
                $bar->advance();
                continue;
            }

            $localPaths = [];
            foreach ($supabaseUrls as $url) {
                $localPath = $this->downloadImage($url, 'news', $skipDownload, $dryRun);
                if ($localPath) {
                    $localPaths[] = $localPath;
                }
            }

            if (!empty($localPaths) && !$dryRun) {
                $galleryUrls = array_map(fn($p) => Storage::disk('public')->url($p), $localPaths);
                $news->update([
                    'image_url'       => $galleryUrls[0],
                    'gallery_uploads' => $localPaths,
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  ✅ News processed\n");
    }

    // ──────────────────────────────────────────────
    // CULTURE
    // ──────────────────────────────────────────────
    private function importCulture(bool $skipDownload, bool $dryRun): void
    {
        $this->info('🎭 Processing CULTURE EVENTS...');

        $data = $this->loadJson('database/data/culture.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $item) {
            $imgs = is_array($item['img']) ? $item['img'] : [];
            $supabaseUrls = array_values(array_filter($imgs, fn($u) => is_string($u) && str_contains($u, 'supabase')));

            if (empty($supabaseUrls)) {
                $bar->advance();
                continue;
            }

            $title = $item['title'] ?? '';
            $culture = CultureEvent::where('title', $title)->first();

            if (!$culture) {
                $bar->advance();
                continue;
            }

            $localPaths = [];
            foreach ($supabaseUrls as $url) {
                $localPath = $this->downloadImage($url, 'culture', $skipDownload, $dryRun);
                if ($localPath) {
                    $localPaths[] = $localPath;
                }
            }

            if (!empty($localPaths) && !$dryRun) {
                $galleryUrls = array_map(fn($p) => Storage::disk('public')->url($p), $localPaths);
                $culture->update([
                    'image_url' => $galleryUrls[0],
                    'images'    => json_encode($galleryUrls),
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  ✅ Culture events processed\n");
    }

    // ──────────────────────────────────────────────
    // AWARDS
    // ──────────────────────────────────────────────
    private function importAwards(bool $skipDownload, bool $dryRun): void
    {
        $this->info('🏆 Processing AWARDS...');

        $data = $this->loadJson('database/data/awards.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $item) {
            $imgs = is_array($item['img']) ? $item['img'] : [];
            $supabaseUrls = array_values(array_filter($imgs, fn($u) => is_string($u) && str_contains($u, 'supabase')));

            if (empty($supabaseUrls)) {
                $bar->advance();
                continue;
            }

            $award = Award::where('title', $item['title'] ?? '')->first();
            if (!$award) {
                $bar->advance();
                continue;
            }

            $localPaths = [];
            foreach ($supabaseUrls as $url) {
                $localPath = $this->downloadImage($url, 'awards', $skipDownload, $dryRun);
                if ($localPath) {
                    $localPaths[] = $localPath;
                }
            }

            if (!empty($localPaths) && !$dryRun) {
                $award->update([
                    'image_url' => Storage::disk('public')->url($localPaths[0]),
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  ✅ Awards processed\n");
    }

    // ──────────────────────────────────────────────
    // MEDIA / PRESS
    // ──────────────────────────────────────────────
    private function importMedia(bool $skipDownload, bool $dryRun): void
    {
        $this->info('📺 Processing PRESS/MEDIA...');

        $data = $this->loadJson('database/data/media.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $item) {
            $imgs = is_array($item['img'] ?? $item['image'] ?? []) ? ($item['img'] ?? $item['image'] ?? []) : [];
            $supabaseUrls = array_values(array_filter($imgs, fn($u) => is_string($u) && str_contains($u, 'supabase')));

            // Also check top-level image_url field
            if (empty($supabaseUrls) && isset($item['image_url']) && str_contains($item['image_url'], 'supabase')) {
                $supabaseUrls = [$item['image_url']];
            }

            if (empty($supabaseUrls)) {
                $bar->advance();
                continue;
            }

            $press = Press::where('title', $item['title'] ?? '')->first();
            if (!$press) {
                $bar->advance();
                continue;
            }

            $localPaths = [];
            foreach ($supabaseUrls as $url) {
                $localPath = $this->downloadImage($url, 'press', $skipDownload, $dryRun);
                if ($localPath) {
                    $localPaths[] = $localPath;
                }
            }

            if (!empty($localPaths) && !$dryRun) {
                $press->update([
                    'image_url' => Storage::disk('public')->url($localPaths[0]),
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  ✅ Press/Media processed\n");
    }

    // ──────────────────────────────────────────────
    // HELPERS
    // ──────────────────────────────────────────────

    /**
     * Download a single image from Supabase to local storage.
     * Returns the local storage path (relative to public disk) or null on failure.
     */
    private function downloadImage(string $url, string $folder, bool $skipDownload, bool $dryRun): ?string
    {
        $filename = basename(parse_url($url, PHP_URL_PATH));
        $localPath = "supabase/{$folder}/{$filename}";

        // Already downloaded
        if (Storage::disk('public')->exists($localPath)) {
            $this->skipped++;
            return $localPath;
        }

        if ($dryRun) {
            $this->info("  [DRY-RUN] Would download: $url → storage/app/public/$localPath");
            return $localPath;
        }

        if ($skipDownload) {
            return $localPath;
        }

        try {
            $response = Http::timeout(30)->get($url);

            if ($response->successful()) {
                Storage::disk('public')->put($localPath, $response->body());
                $this->downloaded++;
                return $localPath;
            } else {
                $this->warn("  ⚠ Failed ($response->status()): $url");
                $this->failed++;
                return null;
            }
        } catch (\Exception $e) {
            $this->warn("  ⚠ Error: " . $e->getMessage());
            $this->failed++;
            return null;
        }
    }

    /**
     * Register downloaded images with Spatie Media Library so Filament can preview them.
     */
    private function registerMediaForProject(Project $project, array $localPaths): void
    {
        try {
            // Clear existing gallery media
            $project->clearMediaCollection('gallery');

            foreach ($localPaths as $i => $path) {
                $fullPath = Storage::disk('public')->path($path);
                if (file_exists($fullPath)) {
                    $project->addMedia($fullPath)
                        ->preservingOriginal()
                        ->toMediaCollection($i === 0 ? 'cover_image' : 'gallery');
                }
            }
        } catch (\Exception $e) {
            // Media library may not be set up for all models — silently skip
        }
    }

    /**
     * Load a JSON file robustly (handles BOM, CRLF, etc.)
     */
    private function loadJson(string $path): array
    {
        $raw = file_get_contents(base_path($path));
        // Strip BOM if present
        $raw = ltrim($raw, "\xEF\xBB\xBF");
        // Normalize line endings
        $raw = str_replace("\r\n", "\n", $raw);
        $decoded = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Failed to parse $path: " . json_last_error_msg());
            return ['value' => []];
        }
        return $decoded;
    }
}
