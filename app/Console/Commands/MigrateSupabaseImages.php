<?php

namespace App\Console\Commands;

use App\Models\Project; // ← swap this for whichever model holds your image URLs
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateSupabaseImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Options:
     *   --model=Project     Which Eloquent model to scan (default: Project)
     *   --column=image_path Which column holds the Supabase URL
     *   --disk=public       Which Laravel Storage disk to save to
     *   --dry-run           Simulate without downloading or updating the DB
     */
    protected $signature = 'migrate:supabase-images
                            {--model=Project        : Eloquent model class name (in App\\Models)}
                            {--column=image_path    : DB column that holds the Supabase URL}
                            {--disk=public          : Laravel storage disk to save files to}
                            {--dry-run              : Preview what would happen without making changes}';

    protected $description = 'Download all images from Supabase storage and save them to the local Laravel storage disk, then update the database records.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // ── Resolve options ──────────────────────────────────────────────────
        $modelClass = 'App\\Models\\' . $this->option('model');
        $column     = trim($this->option('column'));
        $disk       = $this->option('disk');
        $isDryRun   = $this->option('dry-run');

        // Validate the model class
        if (!class_exists($modelClass)) {
            $this->error("❌  Model [{$modelClass}] not found. Check the --model option.");
            return self::FAILURE;
        }

        $this->info("──────────────────────────────────────────────────────");
        $this->info("  Builtech — Supabase Image Migration");
        $this->info("──────────────────────────────────────────────────────");
        $this->info("  Model  : {$modelClass}");
        $this->info("  Column : {$column}");
        $this->info("  Disk   : {$disk}");
        $this->warn($isDryRun ? "  Mode   : DRY RUN (no changes will be saved)" : "  Mode   : LIVE");
        $this->info("──────────────────────────────────────────────────────");

        // ── Fetch all records that still have a Supabase URL ────────────────
        // We identify Supabase URLs by the 'supabase.co' hostname.
        // Adjust the LIKE pattern if your URLs look different.
        $records = $modelClass::whereNotNull($column)
            ->where($column, 'like', '%supabase.co%')
            ->get();

        if ($records->isEmpty()) {
            $this->info("✅  No Supabase image URLs found. Nothing to migrate.");
            return self::SUCCESS;
        }

        $this->info("📦  Found {$records->count()} record(s) to process.\n");

        $successCount = 0;
        $failCount    = 0;

        // ── Progress bar ─────────────────────────────────────────────────────
        $bar = $this->output->createProgressBar($records->count());
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% — %message%');
        $bar->setMessage('Starting...');
        $bar->start();

        foreach ($records as $record) {
            $supabaseUrl = $record->{$column};
            $bar->setMessage("ID #{$record->id}");

            // ── Skip if not a valid URL ──────────────────────────────────────
            if (!filter_var($supabaseUrl, FILTER_VALIDATE_URL)) {
                $this->newLine();
                $this->warn("  ⚠  ID #{$record->id}: Invalid URL — skipping.");
                $failCount++;
                $bar->advance();
                continue;
            }

            // ── Build local storage path ─────────────────────────────────────
            // Example result: 'projects/original-filename.jpg'
            $originalFilename = basename(parse_url($supabaseUrl, PHP_URL_PATH));
            $extension        = pathinfo($originalFilename, PATHINFO_EXTENSION) ?: 'jpg';
            $safeFilename     = Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)) . '.' . $extension;
            $storagePath      = 'projects/' . $safeFilename; // e.g. storage/app/public/projects/my-image.jpg

            if ($isDryRun) {
                $this->newLine();
                $this->line("  [DRY RUN] ID #{$record->id}: {$supabaseUrl}");
                $this->line("             → Would save to: {$storagePath}");
                $successCount++;
                $bar->advance();
                continue;
            }

            // ── Download the image from Supabase ─────────────────────────────
            try {
                $response = Http::timeout(30)
                    ->withHeaders(['Accept' => 'image/*'])
                    ->get($supabaseUrl);

                if (!$response->successful()) {
                    throw new \RuntimeException("HTTP {$response->status()} from Supabase.");
                }

                $imageContents = $response->body();

            } catch (\Throwable $e) {
                $this->newLine();
                $this->error("  ❌  ID #{$record->id}: Download failed — {$e->getMessage()}");
                $failCount++;
                $bar->advance();
                continue;
            }

            // ── Save to Laravel Storage ───────────────────────────────────────
            try {
                Storage::disk($disk)->put($storagePath, $imageContents);
            } catch (\Throwable $e) {
                $this->newLine();
                $this->error("  ❌  ID #{$record->id}: Storage save failed — {$e->getMessage()}");
                $failCount++;
                $bar->advance();
                continue;
            }

            // ── Update the database record ────────────────────────────────────
            // The new value is the relative path used by Storage::url() / asset()
            try {
                $record->update([$column => $storagePath]);
                $successCount++;
            } catch (\Throwable $e) {
                $this->newLine();
                $this->error("  ❌  ID #{$record->id}: DB update failed — {$e->getMessage()}");
                $failCount++;
                $bar->advance();
                continue;
            }

            $bar->advance();
        }

        $bar->finish();

        // ── Summary ──────────────────────────────────────────────────────────
        $this->newLine(2);
        $this->info("──────────────────────────────────────────────────────");
        $this->info("  Migration Complete");
        $this->info("──────────────────────────────────────────────────────");
        $this->info("  ✅  Succeeded : {$successCount}");

        if ($failCount > 0) {
            $this->warn("  ⚠   Failed    : {$failCount}");
        } else {
            $this->info("  ✅  Failed    : 0");
        }

        $this->info("──────────────────────────────────────────────────────");

        if (!$isDryRun && $successCount > 0) {
            $this->newLine();
            $this->info("💡  Tip: Run [php artisan storage:link] if you haven't already");
            $this->info("         to make public disk files accessible from the browser.");
        }

        return $failCount > 0 ? self::FAILURE : self::SUCCESS;
    }
}
