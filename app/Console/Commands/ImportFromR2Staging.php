<?php

namespace App\Console\Commands;

use App\Models\CultureEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImportFromR2Staging extends Command
{
    protected $signature = 'media:import-from-r2-staging
        {--prefix=_staging : Staging folder prefix on R2}
        {--dry-run : Show what would happen without writing anything}
        {--keep-staging : Do not delete staging files after a successful import}
        {--cover-collection=culture_image : Spatie collection for the first photo per event (if event has no cover yet)}
        {--gallery-collection=gallery : Spatie collection for the remaining photos}';

    protected $description = 'Bulk-import photos uploaded to R2 staging area (folders named after CultureEvent titles) into proper Spatie media collections.';

    private array $imageExt = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'heic'];

    public function handle(): int
    {
        $disk   = Storage::disk('public'); // R2 in production
        $prefix = rtrim($this->option('prefix'), '/');
        $dryRun = (bool) $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN — no DB writes, no file moves, no staging cleanup.');
            $this->newLine();
        }

        $folders = $disk->directories($prefix);
        if (empty($folders)) {
            $this->info("No folders found in {$prefix}/. Upload via rclone first, then re-run.");
            return self::SUCCESS;
        }

        $this->info('Found '.count($folders)." event folder(s) in {$prefix}/");

        $totalImported = 0;
        $unmatched     = [];
        $ambiguous     = [];

        foreach ($folders as $folder) {
            $eventName = basename($folder);
            $this->newLine();
            $this->info("=== {$eventName} ===");

            $matches = $this->findEvents($eventName);

            if ($matches->isEmpty()) {
                $this->warn("  no CultureEvent matches — skipped (photos stay in staging)");
                $unmatched[] = $eventName;
                continue;
            }

            if ($matches->count() > 1) {
                $ids = $matches->pluck('id')->implode(', ');
                $this->warn("  AMBIGUOUS — {$matches->count()} events match this title (ids: {$ids}). Skipping. Rename folder to disambiguate, or pick manually.");
                $ambiguous[] = $eventName;
                continue;
            }

            $event = $matches->first();
            $this->line("  matched CultureEvent #{$event->id}: \"{$event->title}\"");

            $files = collect($disk->files($folder))
                ->filter(fn ($f) => in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), $this->imageExt))
                ->sort()
                ->values();

            if ($files->isEmpty()) {
                $this->line('  (no image files in folder)');
                continue;
            }

            $coverCollection   = $this->option('cover-collection');
            $galleryCollection = $this->option('gallery-collection');
            $eventHasCover     = $event->hasMedia($coverCollection);

            $importedHere = 0;
            $failedHere   = 0;

            foreach ($files as $i => $filePath) {
                $useCollection = (! $eventHasCover && $i === 0) ? $coverCollection : $galleryCollection;
                $basename      = basename($filePath);

                $this->line("  → [{$useCollection}] {$basename}");

                if ($dryRun) {
                    $importedHere++;
                    continue;
                }

                try {
                    $bytes = $disk->get($filePath);
                    if (! $bytes) {
                        $this->error("    skip: empty file");
                        $failedHere++;
                        continue;
                    }

                    $event->addMediaFromString($bytes)
                        ->usingFileName($basename)
                        ->toMediaCollection($useCollection);

                    $importedHere++;
                } catch (Throwable $e) {
                    $this->error("    failed: ".$e->getMessage());
                    $failedHere++;
                }
            }

            $totalImported += $importedHere;
            $this->line("  → imported {$importedHere}, failed {$failedHere}");

            // Clean up staging only on full success
            $allSucceeded = $failedHere === 0 && $importedHere === $files->count();
            if (! $dryRun && $allSucceeded && ! $this->option('keep-staging')) {
                foreach ($files as $f) {
                    $disk->delete($f);
                }
                $disk->deleteDirectory($folder);
                $this->line("  ✓ staging cleaned up");
            } elseif (! $allSucceeded) {
                $this->warn("  staging KEPT for retry");
            }
        }

        $this->newLine();
        $this->info("Total photos imported: {$totalImported}");

        if (! empty($unmatched)) {
            $this->newLine();
            $this->warn(count($unmatched).' folder(s) had no matching CultureEvent:');
            foreach ($unmatched as $name) {
                $this->line("  - {$name}");
            }
            $this->comment('Rename these folders to match an existing event title, then re-run.');
        }

        if (! empty($ambiguous)) {
            $this->newLine();
            $this->warn(count($ambiguous).' folder(s) matched multiple events:');
            foreach ($ambiguous as $name) {
                $this->line("  - {$name}");
            }
        }

        if (! $dryRun && $totalImported > 0) {
            $this->newLine();
            $this->info('Resetting DB sequences after bulk insert…');
            $this->call('db:reset-sequences');
        }

        return self::SUCCESS;
    }

    private function findEvents(string $name)
    {
        // Try in order of strictness; return the first non-empty match set.
        $strategies = [
            fn () => CultureEvent::where('title', $name)->get(),
            fn () => CultureEvent::whereRaw('LOWER(title) = ?', [strtolower($name)])->get(),
            fn () => CultureEvent::whereRaw('LOWER(TRIM(title)) = ?', [strtolower(trim($name))])->get(),
        ];

        foreach ($strategies as $strategy) {
            $result = $strategy();
            if ($result->isNotEmpty()) {
                return $result;
            }
        }

        return collect();
    }
}
