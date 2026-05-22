<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Project;
use App\Models\Award;
use App\Models\News;
use App\Models\CultureEvent;
use App\Models\Inquiry;
use App\Models\JobOpening;
use App\Models\PressCoverage;
use App\Models\CurrentProject;

/**
 * ============================================================
 *  php artisan supabase:migrate
 * ============================================================
 *  Connects to your live Supabase project and pulls down EVERY
 *  single record from all 8 tables, then saves them into your
 *  local SQLite database.
 *
 *  SAFE TO RE-RUN — uses updateOrCreate so records are never
 *  duplicated.
 * ============================================================
 */
class MigrateSupabaseCommand extends Command
{
    protected $signature   = 'supabase:migrate {--table= : Migrate only one table (optional)}';
    protected $description = '🚀 Pull ALL data from your live Supabase project into local Herd database';

    // ── Credentials from cms.js ──────────────────────────────
    private string $supabaseUrl = 'https://guvifomiadxehmtrqrfu.supabase.co';
    private string $supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imd1dmlmb21pYWR4ZWhtdHJxcmZ1Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzMxMDc1MjUsImV4cCI6MjA4ODY4MzUyNX0.8gy3oPTSwPXCZHAi0FbmpjkIrHQuZmWd_TE-h-L0gD8';

    public function handle(): int
    {
        $this->info('');
        $this->info('╔══════════════════════════════════════════════════════╗');
        $this->info('║     BUILTECH  ·  Supabase → Herd Data Migration      ║');
        $this->info('╚══════════════════════════════════════════════════════╝');
        $this->info('');

        $onlyTable = $this->option('table');

        $tables = [
            'projects'         => [$this, 'migrateProjects'],
            'awards'           => [$this, 'migrateAwards'],
            'news'             => [$this, 'migrateNews'],
            'culture'          => [$this, 'migrateCulture'],
            'inquiries'        => [$this, 'migrateInquiries'],
            'job_openings'     => [$this, 'migrateJobOpenings'],
            'press_coverage'   => [$this, 'migratePressConverage'],
            'current_projects' => [$this, 'migrateCurrentProjects'],
        ];

        foreach ($tables as $tableName => $handler) {
            if ($onlyTable && $onlyTable !== $tableName) {
                continue;
            }

            $this->line("  ⏳  Fetching <fg=yellow>{$tableName}</fg=yellow>...");
            $rows = $this->fetchFromSupabase($tableName);

            if ($rows === null) {
                $this->warn("  ⚠️   Table '{$tableName}' not found or permission denied — skipping.");
                continue;
            }

            call_user_func($handler, $rows);
        }

        $this->info('');
        $this->info('✅  Migration complete! All records are now in your local database.');
        $this->info('');

        return self::SUCCESS;
    }

    // ── HTTP Helper ─────────────────────────────────────────

    /**
     * Fetch ALL rows from a Supabase table using the REST API.
     * Uses Prefer: count=exact and Range header to page through all rows
     * even if Supabase caps a single response at 1000 rows.
     */
    private function fetchFromSupabase(string $table): ?array
    {
        $allRows = [];
        $pageSize = 1000;
        $offset   = 0;

        do {
            $response = Http::withHeaders([
                'apikey'        => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Range'         => "{$offset}-" . ($offset + $pageSize - 1),
                'Prefer'        => 'count=exact',
            ])->get("{$this->supabaseUrl}/rest/v1/{$table}", [
                'select' => '*',
                'order'  => 'id.asc',
            ]);

            if ($response->status() === 404 || $response->status() === 400) {
                return null;
            }

            if (!$response->successful()) {
                $this->error("  ✗  HTTP {$response->status()} for table: {$table}");
                return [];
            }

            $rows     = $response->json();
            $allRows  = array_merge($allRows, $rows);
            $offset  += $pageSize;

        } while (count($rows) === $pageSize);

        return $allRows;
    }

    // ── Table Handlers ───────────────────────────────────────

    private function migrateProjects(array $rows): void
    {
        $count = 0;
        foreach ($rows as $r) {
            $imageUrl = $this->resolveImage($r);
            $slug     = Str::slug(($r['title'] ?? $r['name'] ?? 'project') . '-' . ($r['id'] ?? ''));

            Project::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'          => $r['title']  ?? $r['name']           ?? 'Untitled',
                    'description'   => $r['description']                    ?? null,
                    'client'        => $r['client']                         ?? null,
                    'location'      => $r['loc']    ?? $r['location']       ?? null,
                    'category'      => $r['cat']    ?? $r['category']       ?? 'General Construction',
                    'status'        => $r['status'] ?? $r['project_status'] ?? 'Completed',
                    'year'          => (int)($r['year'] ?? $r['completion_year'] ?? date('Y')),
                    'is_flagship'   => (bool)($r['is_flagship'] ?? false),
                    'is_published'  => true,
                    'sort_order'    => (int)($r['sort_order'] ?? 0),
                    'image_url'     => $imageUrl,
                    'contract_value'=> $r['contract_value'] ?? null,
                ]
            );
            $count++;
        }
        $this->info("  ✅  Projects: <fg=green>{$count} records</fg=green> saved.");
    }

    private function migrateAwards(array $rows): void
    {
        $count = 0;
        foreach ($rows as $r) {
            $imageUrl = $this->resolveImage($r);
            Award::updateOrCreate(
                ['name' => $r['title'] ?? $r['name'] ?? 'Untitled Award'],
                [
                    'year'        => (int)($r['year'] ?? 0),
                    'category'    => $r['cat']    ?? $r['category']  ?? 'Other',
                    'description' => $r['desc']   ?? $r['description'] ?? null,
                    'issuer'      => $r['issuer']                     ?? null,
                    'image_url'   => $imageUrl,
                ]
            );
            $count++;
        }
        $this->info("  ✅  Awards: <fg=green>{$count} records</fg=green> saved.");
    }

    private function migrateNews(array $rows): void
    {
        $count = 0;
        foreach ($rows as $r) {
            $imageUrl = $this->resolveImage($r);
            $date     = $this->parseDate($r['date'] ?? $r['publish_date'] ?? null);
            $slug     = Str::slug(($r['title'] ?? 'news') . '-' . ($r['id'] ?? ''));

            News::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'          => $r['title']             ?? 'Untitled News',
                    'content'        => $r['content']           ?? $r['description'] ?? null,
                    'excerpt'        => $r['excerpt']           ?? null,
                    'published_date' => $date,
                    'category'       => $r['category']          ?? $r['type'] ?? 'General',
                    'image_url'      => $imageUrl,
                    'author'         => $r['author']            ?? null,
                    'is_published'   => true,
                ]
            );
            $count++;
        }
        $this->info("  ✅  News: <fg=green>{$count} records</fg=green> saved.");
    }

    private function migrateCulture(array $rows): void
    {
        $count = 0;
        foreach ($rows as $r) {
            $imageUrl = $this->resolveImage($r);
            $slug     = Str::slug(($r['title'] ?? $r['name'] ?? 'event') . '-' . ($r['id'] ?? ''));

            CultureEvent::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'       => $r['title']      ?? $r['name']    ?? 'Untitled Event',
                    'name'        => $r['name']                        ?? null,
                    'event_date'  => $this->parseDate($r['date']       ?? null),
                    'year'        => (int)($r['year']                  ?? date('Y')),
                    'category'    => $r['category']   ?? $r['cat']     ?? null,
                    'description' => $r['description'] ?? $r['desc']   ?? null,
                    'image_url'   => $imageUrl,
                ]
            );
            $count++;
        }
        $this->info("  ✅  Culture Events: <fg=green>{$count} records</fg=green> saved.");
    }

    private function migrateInquiries(array $rows): void
    {
        $count = 0;
        foreach ($rows as $r) {
            Inquiry::updateOrCreate(
                [
                    'email'   => $r['email'] ?? 'unknown@unknown.com',
                    'subject' => $r['subject'] ?? null,
                ],
                [
                    'name'    => $r['name']    ?? 'Unknown',
                    'phone'   => $r['phone']   ?? null,
                    'message' => $r['message'] ?? '',
                    'status'  => $r['status']  ?? 'New',
                ]
            );
            $count++;
        }
        $this->info("  ✅  Inquiries: <fg=green>{$count} records</fg=green> saved.");
    }

    private function migrateJobOpenings(array $rows): void
    {
        $count = 0;
        foreach ($rows as $r) {
            $title = $r['position_title'] ?? $r['title'] ?? 'Untitled Position';
            $slug  = Str::slug($title . '-' . ($r['id'] ?? ''));

            JobOpening::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'        => $title,
                    'department'   => $r['department']    ?? null,
                    'location'     => $r['location']      ?? null,
                    'type'         => $r['type']          ?? $r['employment_type'] ?? 'Full-Time',
                    'description'  => $r['description']   ?? null,
                    'requirements' => $r['requirements']  ?? null,
                    'is_active'    => (bool)($r['is_active']    ?? true),
                    'is_available' => (bool)($r['is_available'] ?? true),
                    'sort_order'   => (int)($r['sort_order'] ?? 0),
                ]
            );
            $count++;
        }
        $this->info("  ✅  Job Openings: <fg=green>{$count} records</fg=green> saved.");
    }

    private function migratePressConverage(array $rows): void
    {
        $count = 0;
        foreach ($rows as $r) {
            $imageUrl = $this->resolveImage($r);
            PressCoverage::updateOrCreate(
                ['headline' => $r['headline'] ?? $r['title'] ?? 'Untitled'],
                [
                    'publication'    => $r['publication'] ?? $r['source'] ?? null,
                    'published_date' => $this->parseDate($r['date'] ?? $r['publish_date'] ?? null),
                    'external_url'   => $r['external_url'] ?? $r['url'] ?? $r['clipping_url'] ?? null,
                    'excerpt'        => $r['excerpt']      ?? $r['description'] ?? null,
                    'image_url'      => $imageUrl,
                ]
            );
            $count++;
        }
        $this->info("  ✅  Press Coverage: <fg=green>{$count} records</fg=green> saved.");
    }

    private function migrateCurrentProjects(array $rows): void
    {
        $count = 0;
        foreach ($rows as $r) {
            $imageUrl = $this->resolveImage($r);
            $slug     = Str::slug(($r['title'] ?? $r['name'] ?? 'project') . '-' . ($r['id'] ?? ''));

            CurrentProject::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'          => $r['title']   ?? $r['name']     ?? 'Untitled',
                    'location'       => $r['loc']     ?? $r['location'] ?? null,
                    'category'       => $r['cat']     ?? $r['category'] ?? null,
                    'status'         => $r['status']                    ?? 'Ongoing',
                    'description'    => $r['description']               ?? null,
                    'client'         => $r['client']                    ?? null,
                    'year'           => (int)($r['year'] ?? date('Y')),
                    'contract_value' => $r['contract_value']            ?? null,
                    'image_url'      => $imageUrl,
                    'is_active'      => (bool)($r['is_active'] ?? true),
                    'sort_order'     => (int)($r['sort_order'] ?? 0),
                ]
            );
            $count++;
        }
        $this->info("  ✅  Current Projects: <fg=green>{$count} records</fg=green> saved.");
    }

    // ── Utility ──────────────────────────────────────────────

    /**
     * Smartly resolves the image URL from any Supabase field name variant.
     * The CMS.js used many different field names across tables.
     */
    private function resolveImage(array $r): ?string
    {
        $raw = $r['image_url']
            ?? $r['img']
            ?? $r['photos']
            ?? $r['thumbnail_url']
            ?? $r['image']
            ?? $r['clipping_url']
            ?? null;

        if (!$raw) return null;

        // If it's a JSON array (Supabase stored arrays as JSON strings)
        if (is_string($raw) && (str_starts_with($raw, '[') || str_starts_with($raw, '{'))) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $first = $decoded[0];
                return is_string($first) ? $first : ($first['url'] ?? $first['path'] ?? null);
            }
        }

        if (is_array($raw)) {
            $first = $raw[0] ?? null;
            return is_string($first) ? $first : ($first['url'] ?? $first['path'] ?? null);
        }

        return is_string($raw) ? $raw : null;
    }

    /**
     * Convert DD/MM/YYYY or any date format to YYYY-MM-DD.
     */
    private function parseDate(?string $date): ?string
    {
        if (!$date) return null;

        // DD/MM/YYYY
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $date, $m)) {
            return "{$m[3]}-{$m[2]}-{$m[1]}";
        }

        // Try generic parse
        try {
            return date('Y-m-d', strtotime($date));
        } catch (\Throwable) {
            return null;
        }
    }
}
