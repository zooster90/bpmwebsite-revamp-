<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportMediaRows extends Command
{
    protected $signature = 'media:export-rows
        {--min-id= : Only export media rows with id >= this value}
        {--out=media_dump.json : Output file path (default: media_dump.json in project root)}';

    protected $description = 'Export rows from the media table to a JSON file (for migrating from local dev to live)';

    public function handle(): int
    {
        $query = DB::table('media')->orderBy('id');

        if ($minId = $this->option('min-id')) {
            $query->where('id', '>=', (int) $minId);
        }

        $rows = $query->get()->map(fn ($row) => (array) $row)->toArray();
        $out  = $this->option('out');

        file_put_contents($out, json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info(count($rows)." media rows exported to {$out}");
        $this->line("File size: ".number_format(filesize($out) / 1024, 1)." KB");
        return self::SUCCESS;
    }
}
