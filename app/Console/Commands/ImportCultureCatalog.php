<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ImportCultureCatalog extends Command
{
    protected $signature = 'culture:import-catalog
        {events_json : Path to culture_events JSON dump}
        {categories_json : Path to categories JSON dump (CultureEvent rows only)}
        {--dry-run : Show plan without writing}';

    protected $description = 'Safely import intern\'s CultureEvent + Category data to live. Skips duplicates by slug/title, remaps IDs, preserves live data.';

    private int $catsInserted = 0;
    private int $catsSkipped  = 0;
    private int $evtInserted  = 0;
    private int $evtSkipped   = 0;
    private int $evtUpdated   = 0;

    public function handle(): int
    {
        $eventsJson = $this->argument('events_json');
        $catsJson   = $this->argument('categories_json');

        if (! is_file($eventsJson) || ! is_file($catsJson)) {
            $this->error('JSON file(s) not found.');
            return self::INVALID;
        }

        $internEvents = json_decode(file_get_contents($eventsJson), true);
        $internCats   = json_decode(file_get_contents($catsJson), true);

        if (! is_array($internEvents) || ! is_array($internCats)) {
            $this->error('JSON could not be parsed as arrays.');
            return self::INVALID;
        }

        $dryRun = (bool) $this->option('dry-run');
        if ($dryRun) {
            $this->warn('DRY RUN — no DB writes.');
            $this->newLine();
        }

        // ── Step 1: categories ─────────────────────────────────────────────
        $this->info('=== Categories ===');
        $catMap = $this->importCategories($internCats, $dryRun);
        $this->info("  inserted: {$this->catsInserted}, skipped (already on live): {$this->catsSkipped}");
        $this->info('  built mapping for '.count($catMap).' intern_cat_id → live_cat_id');

        // ── Step 2: events ─────────────────────────────────────────────────
        $this->newLine();
        $this->info('=== Culture Events ===');
        $this->importEvents($internEvents, $catMap, $dryRun);
        $this->info("  inserted: {$this->evtInserted}, updated (categorization filled in): {$this->evtUpdated}, skipped (already on live with categories): {$this->evtSkipped}");

        if (! $dryRun) {
            $this->newLine();
            $this->info('Resetting DB sequences…');
            $this->call('db:reset-sequences');
        }

        return self::SUCCESS;
    }

    /**
     * For each intern category, find or insert on live. Return id mapping.
     */
    private function importCategories(array $internCats, bool $dryRun): array
    {
        $map = [];

        foreach ($internCats as $row) {
            $slug = $row['slug'] ?? null;
            $name = $row['name'] ?? null;
            if (! $slug || ! $name) {
                continue;
            }

            // Try match by (model_type, slug) first, then by (model_type, name)
            $live = DB::table('categories')
                ->where('model_type', 'CultureEvent')
                ->where('slug', $slug)
                ->first();

            if (! $live) {
                $live = DB::table('categories')
                    ->where('model_type', 'CultureEvent')
                    ->whereRaw('LOWER(name) = ?', [strtolower($name)])
                    ->first();
            }

            if ($live) {
                $map[$row['id']] = (int) $live->id;
                $this->catsSkipped++;
                continue;
            }

            $insertRow = [
                'name'       => $name,
                'slug'       => $slug,
                'model_type' => 'CultureEvent',
                'parent_id'  => null, // remapped below in second pass if needed
                'sort_order' => $row['sort_order'] ?? 0,
                'created_at' => $row['created_at'] ?? now(),
                'updated_at' => now(),
            ];

            if ($dryRun) {
                $this->line("  [would insert] {$slug} → {$name}");
                $map[$row['id']] = -$row['id']; // sentinel
                $this->catsInserted++;
                continue;
            }

            try {
                $newId = DB::table('categories')->insertGetId($insertRow);
                $map[$row['id']] = $newId;
                $this->catsInserted++;
                $this->line("  ✓ inserted #{$newId} {$slug}");
            } catch (Throwable $e) {
                $this->error("  failed to insert {$slug}: ".$e->getMessage());
            }
        }

        // Second pass: remap parent_id for newly inserted categories
        if (! $dryRun) {
            foreach ($internCats as $row) {
                $internId = $row['id'];
                $parentInternId = $row['parent_id'] ?? null;
                if (! $parentInternId || ! isset($map[$internId], $map[$parentInternId])) {
                    continue;
                }
                $liveId = $map[$internId];
                $liveParentId = $map[$parentInternId];
                DB::table('categories')->where('id', $liveId)->update(['parent_id' => $liveParentId]);
            }
        }

        return $map;
    }

    /**
     * For each intern event, insert (with remapped category ids) or update existing live row's categorization.
     */
    private function importEvents(array $internEvents, array $catMap, bool $dryRun): void
    {
        $allowedCols = [
            'title', 'slug', 'event_date', 'description', 'image_url', 'year',
            'name', 'culture_image_upload', 'gallery_uploads', 'is_published',
            'location', 'intern_name', 'university', 'department', 'intern_period',
            'category_id', 'sub_category_id', 'video_url', 'video_upload',
            'created_at', 'updated_at',
        ];

        foreach ($internEvents as $row) {
            $title = trim($row['title'] ?? '');
            if ($title === '') {
                continue;
            }

            $catId = $row['category_id'] ?? null;
            $subId = $row['sub_category_id'] ?? null;
            $mappedCatId = $catId && isset($catMap[$catId]) && $catMap[$catId] > 0 ? $catMap[$catId] : null;
            $mappedSubId = $subId && isset($catMap[$subId]) && $catMap[$subId] > 0 ? $catMap[$subId] : null;

            $live = DB::table('culture_events')->where('title', $title)->first();

            if ($live) {
                // Existing event — fill in categorization if missing
                $patch = [];
                if (! $live->category_id && $mappedCatId) {
                    $patch['category_id'] = $mappedCatId;
                }
                if (! $live->sub_category_id && $mappedSubId) {
                    $patch['sub_category_id'] = $mappedSubId;
                }

                if (empty($patch)) {
                    $this->evtSkipped++;
                    continue;
                }

                if ($dryRun) {
                    $this->line("  [would update #{$live->id}] {$title} → cat={$mappedCatId} sub={$mappedSubId}");
                    $this->evtUpdated++;
                    continue;
                }

                DB::table('culture_events')->where('id', $live->id)->update($patch);
                $this->evtUpdated++;
                $this->line("  ↺ updated #{$live->id} {$title}");
                continue;
            }

            // New event — insert with remapped category ids
            $insertRow = [];
            foreach ($allowedCols as $col) {
                if (array_key_exists($col, $row)) {
                    $insertRow[$col] = $row[$col];
                }
            }
            $insertRow['category_id']     = $mappedCatId;
            $insertRow['sub_category_id'] = $mappedSubId;
            $insertRow['updated_at']      = now();

            if (empty($insertRow['slug'])) {
                $insertRow['slug'] = Str::slug($title).'-'.Str::random(5);
            }

            if ($dryRun) {
                $this->line("  [would insert] {$title} (cat={$mappedCatId} sub={$mappedSubId})");
                $this->evtInserted++;
                continue;
            }

            try {
                // Ensure slug uniqueness on live
                $base = $insertRow['slug'];
                $i = 0;
                while (DB::table('culture_events')->where('slug', $insertRow['slug'])->exists()) {
                    $i++;
                    $insertRow['slug'] = $base.'-'.$i;
                    if ($i > 10) break;
                }

                $newId = DB::table('culture_events')->insertGetId($insertRow);
                $this->evtInserted++;
                $this->line("  ✓ inserted #{$newId} {$title}");
            } catch (Throwable $e) {
                $this->error("  failed to insert {$title}: ".$e->getMessage());
            }
        }
    }
}
