<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class FindOrphanMedia extends Command
{
    protected $signature = 'media:find-orphans
        {--delete : Delete orphan media rows from DB after listing}
        {--min-id= : Only scan media rows with id >= this}
        {--limit=5000 : Safety cap on rows scanned per run}';

    protected $description = 'Find media table rows whose files do NOT exist on R2 (likely casualties of pre-R2 ephemeral storage).';

    public function handle(): int
    {
        $cdn = rtrim(env('IMAGE_CDN_URL', ''), '/');
        if (! $cdn) {
            $this->error('IMAGE_CDN_URL not set.');
            return self::INVALID;
        }

        $query = DB::table('media')->orderBy('id');
        if ($min = $this->option('min-id')) {
            $query->where('id', '>=', (int) $min);
        }

        $rows = $query->limit((int) $this->option('limit'))->get();
        $this->info("Scanning {$rows->count()} media rows for missing files on R2…");
        $this->newLine();

        $missing = [];
        $bar = $this->output->createProgressBar($rows->count());
        $bar->start();

        foreach ($rows as $row) {
            $bar->advance();
            $url = "{$cdn}/{$row->id}/{$row->file_name}";
            try {
                $resp = Http::timeout(8)->head($url);
                if (! $resp->successful()) {
                    $missing[] = $row;
                }
            } catch (Throwable) {
                $missing[] = $row;
            }
        }

        $bar->finish();
        $this->newLine(2);

        if (empty($missing)) {
            $this->info('✓ All scanned media files exist on R2. No orphans found.');
            return self::SUCCESS;
        }

        $this->warn(count($missing).' orphan media rows found:');
        $this->newLine();

        foreach ($missing as $m) {
            $this->line(sprintf(
                "  media#%-5d %s #%-4s collection=%-15s file=%s",
                $m->id,
                str_replace('App\\Models\\', '', $m->model_type),
                $m->model_id,
                $m->collection_name,
                $m->file_name
            ));
        }

        $this->newLine();
        $byType = [];
        foreach ($missing as $m) {
            $key = $m->model_type.' / '.$m->collection_name;
            $byType[$key] = ($byType[$key] ?? 0) + 1;
        }
        $this->info('Breakdown:');
        foreach ($byType as $key => $count) {
            $this->line("  {$count}× {$key}");
        }

        if ($this->option('delete')) {
            $ids = array_column((array) $missing, 'id');
            $deleted = DB::table('media')->whereIn('id', $ids)->delete();
            $this->newLine();
            $this->info("✓ Deleted {$deleted} orphan media rows.");
        } else {
            $this->newLine();
            $this->comment('Re-run with --delete to remove these orphan rows from the DB.');
        }

        return self::SUCCESS;
    }
}
