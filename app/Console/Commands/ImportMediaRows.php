<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class ImportMediaRows extends Command
{
    protected $signature = 'media:import-rows
        {json : Path to the JSON file (e.g. database/seeds/media_dump.json)}
        {--dry-run : Show what would happen without writing to DB or hitting R2}
        {--skip-file-check : Skip the HEAD request that verifies each file exists on R2}';

    protected $description = 'Import media table rows from a JSON dump. Optionally verifies each file already exists on R2.';

    private int $inserted = 0;
    private int $skippedExisting = 0;
    private int $missingFile = 0;
    private int $failed = 0;

    public function handle(): int
    {
        $jsonPath = $this->argument('json');
        if (! is_file($jsonPath)) {
            $this->error("File not found: {$jsonPath}");
            return self::INVALID;
        }

        $rows = json_decode(file_get_contents($jsonPath), true);
        if (! is_array($rows)) {
            $this->error('JSON could not be parsed as an array of rows.');
            return self::INVALID;
        }

        $dryRun        = (bool) $this->option('dry-run');
        $skipFileCheck = (bool) $this->option('skip-file-check');
        $cdnBase       = rtrim(env('IMAGE_CDN_URL', ''), '/');

        if (! $cdnBase && ! $skipFileCheck) {
            $this->error('IMAGE_CDN_URL is not set. Set it in environment or pass --skip-file-check.');
            return self::INVALID;
        }

        $this->info("Found ".count($rows)." rows in {$jsonPath}");
        if ($dryRun) {
            $this->warn('DRY RUN — no DB writes will happen.');
        }

        $existingIds = DB::table('media')->pluck('id')->all();
        $existingIds = array_flip($existingIds);

        foreach ($rows as $row) {
            $id = $row['id'] ?? null;
            if (! $id) {
                $this->warn('Skipping row with no id');
                $this->failed++;
                continue;
            }

            if (isset($existingIds[$id])) {
                $this->skippedExisting++;
                continue;
            }

            if (! $skipFileCheck) {
                $url = "{$cdnBase}/{$id}/{$row['file_name']}";
                try {
                    $response = Http::timeout(10)->head($url);
                    if (! $response->successful()) {
                        $this->warn("  [#{$id}] file missing on R2 ({$response->status()}): {$url}");
                        $this->missingFile++;
                        continue;
                    }
                } catch (Throwable $e) {
                    $this->warn("  [#{$id}] HEAD check failed: ".$e->getMessage());
                    $this->missingFile++;
                    continue;
                }
            }

            $this->line("  [#{$id}] {$row['model_type']} #{$row['model_id']} / {$row['collection_name']} / {$row['file_name']}");

            if ($dryRun) {
                $this->inserted++;
                continue;
            }

            try {
                DB::table('media')->insert($this->normaliseRow($row));
                $this->inserted++;
            } catch (Throwable $e) {
                $this->error("    insert failed: ".$e->getMessage());
                $this->failed++;
            }
        }

        $this->newLine();
        $this->info("Inserted:           {$this->inserted}");
        $this->info("Skipped (existing): {$this->skippedExisting}");
        $this->info("Missing on R2:      {$this->missingFile}");
        $this->info("Failed:             {$this->failed}");

        if (! $dryRun && $this->inserted > 0) {
            $this->newLine();
            $this->info('Resetting DB sequences (Postgres) so future auto-increment IDs don\'t collide…');
            $this->call('db:reset-sequences');
        }

        return self::SUCCESS;
    }

    private function normaliseRow(array $row): array
    {
        $allowed = [
            'id', 'model_type', 'model_id', 'uuid', 'collection_name', 'name',
            'file_name', 'mime_type', 'disk', 'conversions_disk', 'size',
            'manipulations', 'custom_properties', 'generated_conversions',
            'responsive_images', 'order_column', 'created_at', 'updated_at',
        ];

        $clean = array_intersect_key($row, array_flip($allowed));

        foreach (['manipulations', 'custom_properties', 'generated_conversions', 'responsive_images'] as $jsonField) {
            if (isset($clean[$jsonField]) && ! is_string($clean[$jsonField])) {
                $clean[$jsonField] = json_encode($clean[$jsonField]);
            }
            $clean[$jsonField] = $clean[$jsonField] ?? '[]';
        }

        return $clean;
    }
}
