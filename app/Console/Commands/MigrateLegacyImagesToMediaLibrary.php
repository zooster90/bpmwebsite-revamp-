<?php

namespace App\Console\Commands;

use App\Models\CurrentProject;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Throwable;

class MigrateLegacyImagesToMediaLibrary extends Command
{
    protected $signature = 'images:migrate-to-media-library
        {--dry-run : Show what would be migrated without changing anything}
        {--model= : Limit to a single model: project | current-project}';

    protected $description = 'Migrate legacy image_url / *_upload / gallery_uploads columns into Spatie Media Library so the admin form can edit them';

    private int $migrated = 0;
    private int $skipped = 0;
    private int $failed = 0;

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $only   = $this->option('model');

        if ($dryRun) {
            $this->warn('DRY RUN — no changes will be saved.');
        }

        $targets = [
            'project'         => [Project::class, 'cover_image_upload', 'image_url', 'gallery_uploads'],
            'current-project' => [CurrentProject::class, 'image_upload', 'image_url', 'gallery_uploads'],
        ];

        if ($only && ! isset($targets[$only])) {
            $this->error("Unknown --model={$only}. Use: project, current-project");
            return self::INVALID;
        }

        foreach ($targets as $key => [$modelClass, $coverPrimary, $coverFallback, $galleryColumn]) {
            if ($only && $only !== $key) {
                continue;
            }
            $this->migrateModel($modelClass, $coverPrimary, $coverFallback, $galleryColumn, $dryRun);
        }

        $this->newLine();
        $this->info("Migrated: {$this->migrated}   Skipped: {$this->skipped}   Failed: {$this->failed}");
        return self::SUCCESS;
    }

    private function migrateModel(string $modelClass, string $coverPrimary, string $coverFallback, string $galleryColumn, bool $dryRun): void
    {
        $this->newLine();
        $this->info("=== {$modelClass} ===");

        $modelClass::query()->chunk(50, function ($models) use ($coverPrimary, $coverFallback, $galleryColumn, $dryRun) {
            foreach ($models as $model) {
                $this->migrateCover($model, $coverPrimary, $coverFallback, $dryRun);
                $this->migrateGallery($model, $galleryColumn, $dryRun);
            }
        });
    }

    private function migrateCover(Model $model, string $coverPrimary, string $coverFallback, bool $dryRun): void
    {
        if (! $model instanceof HasMedia) {
            return;
        }

        if ($model->hasMedia('cover_image')) {
            $this->skipped++;
            return;
        }

        $path = $model->{$coverPrimary} ?: $model->{$coverFallback};
        if (! $path) {
            $this->skipped++;
            return;
        }

        $resolved = $this->resolvePath($path);
        if (! $resolved) {
            $this->warn("  [cover] #{$model->getKey()} not found: {$path}");
            $this->failed++;
            return;
        }

        $this->line("  [cover] #{$model->getKey()} ← {$resolved['type']}: {$resolved['source']}");

        if ($dryRun) {
            return;
        }

        try {
            $this->attach($model, $resolved, 'cover_image');
            $this->migrated++;
        } catch (Throwable $e) {
            $this->error("    failed: {$e->getMessage()}");
            $this->failed++;
        }
    }

    private function migrateGallery(Model $model, string $galleryColumn, bool $dryRun): void
    {
        if (! $model instanceof HasMedia) {
            return;
        }

        $raw = $model->{$galleryColumn};
        if (! $raw) {
            return;
        }

        $items = is_array($raw) ? $raw : (json_decode($raw, true) ?: []);
        if (empty($items)) {
            return;
        }

        if ($model->getMedia('gallery')->isNotEmpty()) {
            $this->skipped++;
            return;
        }

        foreach ($items as $item) {
            $path = is_array($item) ? ($item['path'] ?? $item['url'] ?? null) : $item;
            if (! $path) {
                continue;
            }

            $resolved = $this->resolvePath($path);
            if (! $resolved) {
                $this->warn("  [gallery] #{$model->getKey()} not found: {$path}");
                $this->failed++;
                continue;
            }

            $this->line("  [gallery] #{$model->getKey()} ← {$resolved['type']}: {$resolved['source']}");

            if ($dryRun) {
                continue;
            }

            try {
                $this->attach($model, $resolved, 'gallery');
                $this->migrated++;
            } catch (Throwable $e) {
                $this->error("    failed: {$e->getMessage()}");
                $this->failed++;
            }
        }
    }

    /**
     * Resolve a stored path/URL into something we can hand to MediaLibrary.
     * Returns ['type' => 'url'|'file', 'source' => string] or null.
     */
    private function resolvePath(string $path): ?array
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return ['type' => 'url', 'source' => $path];
        }

        $clean = ltrim($path, '/');
        if (str_starts_with($clean, 'public/')) {
            $clean = substr($clean, 7);
        }
        $filename = basename($clean);

        $candidates = [
            public_path($clean),
            public_path('images/' . $filename),
            public_path('img/images/' . $filename),
            public_path('storage/' . $clean),
            storage_path('app/public/' . $clean),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return ['type' => 'file', 'source' => $candidate];
            }
        }

        if ($cdn = config('app.image_cdn_url')) {
            return ['type' => 'url', 'source' => rtrim($cdn, '/') . '/' . $clean];
        }

        return null;
    }

    private function attach(Model $model, array $resolved, string $collection): void
    {
        $adder = $resolved['type'] === 'url'
            ? $model->addMediaFromUrl($resolved['source'])
            : $model->addMedia($resolved['source'])->preservingOriginal();

        $adder->toMediaCollection($collection);
    }
}
