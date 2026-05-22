<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportSqlDump extends Command
{
    protected $signature = 'db:import-supabase
                            {--file=supabase_export.sql : Path to the SQL dump (relative to project root)}
                            {--fresh : Truncate target tables before importing}';

    protected $description = 'Import data from the Supabase Postgres export (INSERT-only dump). Run AFTER php artisan migrate.';

    /**
     * Tables in the dump we do NOT want to re-import, because Laravel
     * manages them itself or they would conflict with the fresh deploy.
     */
    private array $skipTables = [
        'migrations',
        'sessions',
        'cache',
        'cache_locks',
        'jobs',
        'job_batches',
        'failed_jobs',
        'notifications',
        'password_reset_tokens',
        'personal_access_tokens',
    ];

    /**
     * Target order matters for FK-safe truncation (parents last).
     * For Postgres we disable FKs via session_replication_role anyway,
     * but this list helps with --fresh on MySQL.
     */
    private array $importOrder = [
        'roles',
        'categories',
        'users',
        'projects',
        'awards',
        'news',
        'culture_events',
        'job_openings',
        'job_applications',
        'press_coverages',
        'services',
        'our_people',
        'current_projects',
        'media',
        'inquiries',
        'settings',
        'page_views',
        'model_has_roles',
        'activity_log',
    ];

    public function handle(): int
    {
        $path = base_path($this->option('file'));

        if (! is_file($path)) {
            $this->error("SQL dump not found at: {$path}");
            return self::FAILURE;
        }

        $driver = DB::connection()->getDriverName();
        $this->info("Database driver detected: {$driver}");
        $this->info("Reading dump: {$path} (" . number_format(filesize($path) / 1024, 1) . " KB)");

        $sql = file_get_contents($path);
        if ($sql === false) {
            $this->error('Could not read dump file.');
            return self::FAILURE;
        }

        if ($this->option('fresh')) {
            $this->warn('FRESH mode: truncating target tables first.');
            $this->truncate($driver);
        }

        // Group INSERT statements by table so we can skip what we want.
        $byTable = $this->groupInsertsByTable($sql);

        $totalInserted = 0;
        $totalSkipped = 0;

        $this->disableForeignKeys($driver);

        try {
            // Honor the explicit import order, then anything else not in it.
            $orderedTables = array_unique(array_merge(
                $this->importOrder,
                array_keys($byTable),
            ));

            foreach ($orderedTables as $table) {
                if (! isset($byTable[$table])) {
                    continue;
                }

                if (in_array($table, $this->skipTables, true)) {
                    $totalSkipped += count($byTable[$table]);
                    $this->line("  - skip  {$table} (" . count($byTable[$table]) . " rows)");
                    continue;
                }

                if (! Schema::hasTable($table)) {
                    $this->warn("  - miss  {$table} (table does not exist, skipping " . count($byTable[$table]) . " rows)");
                    continue;
                }

                $count = 0;
                $errors = 0;
                foreach ($byTable[$table] as $statement) {
                    try {
                        DB::unprepared($statement);
                        $count++;
                    } catch (\Throwable $e) {
                        $errors++;
                        if ($errors <= 3) {
                            $this->error("    ! {$table}: " . $e->getMessage());
                        }
                    }
                }
                $totalInserted += $count;
                $this->info("  ✓ import {$table} ({$count} ok" . ($errors ? ", {$errors} err" : '') . ")");
            }

            // For Postgres, reset sequences so future inserts use the right next-id.
            if ($driver === 'pgsql') {
                $this->resetPostgresSequences();
            }
        } finally {
            $this->enableForeignKeys($driver);
        }

        $this->newLine();
        $this->info("Done. Inserted {$totalInserted} rows, skipped {$totalSkipped} rows.");
        return self::SUCCESS;
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function groupInsertsByTable(string $sql): array
    {
        $grouped = [];
        $lines = preg_split('/\r?\n/', $sql);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '--') || str_starts_with($line, 'SET ')) {
                continue;
            }
            if (! preg_match('/^INSERT INTO\s+"?([a-zA-Z0-9_]+)"?\s/i', $line, $m)) {
                continue;
            }
            $table = strtolower($m[1]);
            $grouped[$table] ??= [];
            $grouped[$table][] = rtrim($line, ';') . ';';
        }
        return $grouped;
    }

    private function disableForeignKeys(string $driver): void
    {
        try {
            match ($driver) {
                'pgsql' => DB::unprepared("SET session_replication_role = 'replica';"),
                'mysql', 'mariadb' => DB::unprepared('SET FOREIGN_KEY_CHECKS = 0;'),
                'sqlite' => DB::unprepared('PRAGMA foreign_keys = OFF;'),
                default => null,
            };
        } catch (\Throwable $e) {
            // Managed Postgres (Neon, RDS, Supabase) blocks session_replication_role
            // for non-superusers. That's fine — we rely on import order instead.
            $this->warn('FK toggle not permitted on this database. Importing in dependency order.');
        }
    }

    private function enableForeignKeys(string $driver): void
    {
        try {
            match ($driver) {
                'pgsql' => DB::unprepared("SET session_replication_role = 'origin';"),
                'mysql', 'mariadb' => DB::unprepared('SET FOREIGN_KEY_CHECKS = 1;'),
                'sqlite' => DB::unprepared('PRAGMA foreign_keys = ON;'),
                default => null,
            };
        } catch (\Throwable) {
            // ignore — see disableForeignKeys()
        }
    }

    private function truncate(string $driver): void
    {
        foreach (array_reverse($this->importOrder) as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            match ($driver) {
                'pgsql' => DB::unprepared("TRUNCATE TABLE \"{$table}\" RESTART IDENTITY CASCADE;"),
                'mysql', 'mariadb' => DB::unprepared("SET FOREIGN_KEY_CHECKS=0; TRUNCATE TABLE `{$table}`; SET FOREIGN_KEY_CHECKS=1;"),
                'sqlite' => DB::unprepared("DELETE FROM \"{$table}\";"),
                default => null,
            };
        }
    }

    /**
     * After raw INSERTs with explicit IDs, Postgres sequences are behind.
     * Bump every id sequence to MAX(id)+1.
     */
    private function resetPostgresSequences(): void
    {
        try {
            // JOIN with information_schema.columns so we only ask about tables
            // that actually have an 'id' column. pg_get_serial_sequence() errors
            // on a missing column in modern Postgres, so the pre-filter matters.
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
                    $reset++;
                } catch (\Throwable) {
                    // empty table or oddly-typed id — ignore
                }
            }
            $this->info("  ✓ Postgres sequences reset ({$reset} tables)");
        } catch (\Throwable $e) {
            $this->warn('  Sequence reset skipped: ' . $e->getMessage());
        }
    }
}
