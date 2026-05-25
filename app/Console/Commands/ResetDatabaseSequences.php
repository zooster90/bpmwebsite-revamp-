<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class ResetDatabaseSequences extends Command
{
    protected $signature = 'db:reset-sequences';

    protected $description = 'Bump every id sequence to MAX(id)+1 on Postgres (needed after bulk inserts with explicit IDs).';

    public function handle(): int
    {
        if (DB::getDriverName() !== 'pgsql') {
            $this->info('Not Postgres — nothing to do.');
            return self::SUCCESS;
        }

        $rows = DB::select("
            SELECT
                c.table_name,
                pg_get_serial_sequence(quote_ident(c.table_name), 'id') AS seq
            FROM information_schema.columns c
            WHERE c.table_schema = 'public'
              AND c.column_name = 'id'
        ");

        $reset = 0;
        foreach ($rows as $row) {
            if (! $row->seq) {
                continue;
            }
            try {
                DB::statement("SELECT setval('{$row->seq}', COALESCE((SELECT MAX(id) FROM \"{$row->table_name}\"), 1), true)");
                $this->line("  ✓ {$row->table_name}");
                $reset++;
            } catch (Throwable $e) {
                $this->warn("  ! {$row->table_name}: {$e->getMessage()}");
            }
        }

        $this->info("Done. Reset {$reset} sequences.");
        return self::SUCCESS;
    }
}
