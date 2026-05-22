<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MigrateSupabaseData extends Command
{
    protected $signature = 'builtech:migrate-supabase
                            {--no-images : Skip image downloading (seed data only)}
                            {--images-only : Only download images, skip re-seeding}
                            {--fresh : Truncate all tables first (WARNING: deletes existing data)}
                            {--table= : Run only one table: projects|news|culture|awards|media|jobs}';

    protected $description = 'Complete Supabase → Laravel migration: seed all data + download all images to local storage';

    private int $imgDownloaded = 0;
    private int $imgSkipped    = 0;
    private int $imgFailed     = 0;
    private int $records       = 0;

    public function handle(): int
    {
        $this->info('');
        $this->line('╔══════════════════════════════════════════════════════╗');
        $this->line('║   BUILTECH — Full Supabase Migration Command         ║');
        $this->line('║   Downloads images + seeds all accurate data         ║');
        $this->line('╚══════════════════════════════════════════════════════╝');
        $this->info('');

        // Ensure public storage link exists
        if (!is_link(public_path('storage'))) {
            $this->call('storage:link');
        }

        // Create local folders
        foreach (['projects', 'news', 'culture', 'awards', 'press'] as $folder) {
            Storage::disk('public')->makeDirectory("supabase/{$folder}");
        }

        $only    = $this->option('table');
        $noImg   = $this->option('no-images');
        $imgOnly = $this->option('images-only');
        $fresh   = $this->option('fresh');

        if ($fresh && !$imgOnly) {
            if (!$this->confirm('⚠️  --fresh will TRUNCATE all content tables. Continue?')) {
                return 0;
            }
            DB::statement('PRAGMA foreign_keys = OFF');
            foreach (['projects', 'news', 'culture_events', 'awards', 'press_coverages', 'job_openings'] as $tbl) {
                DB::table($tbl)->truncate();
            }
            DB::statement('PRAGMA foreign_keys = ON');
            $this->warn('All content tables truncated.');
        }

        $tables = $only ? [$only] : ['projects', 'news', 'culture', 'awards', 'media', 'jobs'];

        foreach ($tables as $tbl) {
            match ($tbl) {
                'projects' => $imgOnly ? $this->downloadProjectImages() : $this->seedProjects($noImg),
                'news'     => $imgOnly ? $this->downloadNewsImages()    : $this->seedNews($noImg),
                'culture'  => $imgOnly ? $this->downloadCultureImages() : $this->seedCulture($noImg),
                'awards'   => $imgOnly ? $this->downloadAwardImages()   : $this->seedAwards($noImg),
                'media'    => $imgOnly ? $this->downloadMediaImages()   : $this->seedMedia($noImg),
                'jobs'     => $this->seedJobs(),
                default    => $this->warn("Unknown table: $tbl"),
            };
        }

        $this->info('');
        $this->line('╔══════════════════════════════════════════════════════╗');
        $this->line("║  ✅ Records upserted : {$this->records}");
        $this->line("║  📥 Images downloaded: {$this->imgDownloaded}");
        $this->line("║  ⏭  Images skipped  : {$this->imgSkipped} (already local)");
        $this->line("║  ❌ Images failed   : {$this->imgFailed}");
        $this->line('╚══════════════════════════════════════════════════════╝');
        $this->info('');
        $this->info('Run: php artisan serve  →  visit /admin to verify in Filament');

        return 0;
    }

    // ════════════════════════════════════════════════════════
    // PROJECTS
    // ════════════════════════════════════════════════════════
    private function seedProjects(bool $noImg): void
    {
        $this->info('📁 Seeding PROJECTS...');
        $data  = $this->loadJson('database/data/projects.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $idx => $item) {
            $slug = $this->uniqueSlug('projects', $item['title'] ?? 'project', $item['id'] ?? $idx);

            // Determine image URLs
            $imgUrls      = is_array($item['img']) ? array_filter($item['img']) : [];
            $localPaths   = [];
            $coverUrl     = null;

            if (!$noImg && !empty($imgUrls)) {
                foreach ($imgUrls as $url) {
                    $local = $this->downloadImage((string)$url, 'projects');
                    if ($local) {
                        $localPaths[] = $local;
                    }
                }
                $coverUrl = !empty($localPaths)
                    ? Storage::disk('public')->url($localPaths[0])
                    : (string)($imgUrls[0] ?? null);
            } elseif (!empty($imgUrls)) {
                $coverUrl = (string)$imgUrls[0];
            }

            $galleryJson = !empty($localPaths)
                ? json_encode(array_map(fn($p) => Storage::disk('public')->url($p), $localPaths))
                : (!empty($imgUrls) ? json_encode(array_values($imgUrls)) : null);

            DB::table('projects')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name'           => $item['title'] ?? 'Untitled Project',
                    'slug'           => $slug,
                    'category'       => $item['cat'] ?? 'General',
                    'location'       => $item['loc'] ?? null,
                    'status'         => $item['status'] ?? 'Completed',
                    'year'           => $item['year'] ?? null,
                    'description'    => $item['description'] ?? null,
                    'image_url'      => $coverUrl,
                    'gallery_uploads'=> $galleryJson,
                    'is_flagship'    => $item['is_flagship'] ?? false,
                    'is_published'   => true,
                    'sort_order'     => $idx,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );
            $this->records++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  → " . count($items) . " projects seeded.\n");
    }

    private function downloadProjectImages(): void
    {
        $this->info('📁 Downloading PROJECT images...');
        $data = $this->loadJson('database/data/projects.json');
        foreach ($data['value'] ?? [] as $item) {
            foreach (($item['img'] ?? []) as $url) {
                if (str_contains((string)$url, 'supabase')) {
                    $local = $this->downloadImage((string)$url, 'projects');
                    // Update DB with local path
                    if ($local) {
                        $slug = $this->uniqueSlug('projects', $item['title'] ?? 'project', $item['id'] ?? '');
                        $localUrl = Storage::disk('public')->url($local);
                        $project = DB::table('projects')->where('slug', $slug)->first();
                        if ($project && !$project->image_url) {
                            DB::table('projects')->where('slug', $slug)->update(['image_url' => $localUrl]);
                        }
                    }
                }
            }
        }
        $this->info("  ✅ Project images processed.\n");
    }

    // ════════════════════════════════════════════════════════
    // NEWS
    // ════════════════════════════════════════════════════════
    private function seedNews(bool $noImg): void
    {
        $this->info('📰 Seeding NEWS...');
        $data  = $this->loadJson('database/data/news.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $idx => $item) {
            $slug = $this->uniqueSlug('news', $item['title'] ?? 'news', $item['id'] ?? $idx);

            $imgUrls    = is_array($item['img']) ? array_filter(array_map('strval', $item['img'])) : [];
            $localPaths = [];
            $coverUrl   = null;

            if (!$noImg && !empty($imgUrls)) {
                foreach ($imgUrls as $url) {
                    $local = $this->downloadImage($url, 'news');
                    if ($local) {
                        $localPaths[] = $local;
                    }
                }
                $coverUrl = !empty($localPaths)
                    ? Storage::disk('public')->url($localPaths[0])
                    : $imgUrls[0];
            } elseif (!empty($imgUrls)) {
                $coverUrl = $imgUrls[0];
            }

            // Parse date
            $publishedDate = null;
            if (!empty($item['date'])) {
                try {
                    $publishedDate = Carbon::createFromFormat('d/m/Y', $item['date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $publishedDate = now()->format('Y-m-d');
                }
            }

            $galleryJson = !empty($localPaths)
                ? json_encode(array_map(fn($p) => Storage::disk('public')->url($p), $localPaths))
                : (!empty($imgUrls) ? json_encode(array_values($imgUrls)) : null);

            DB::table('news')->updateOrInsert(
                ['slug' => $slug],
                [
                    'title'          => $item['title'] ?? 'Untitled',
                    'slug'           => $slug,
                    'category'       => $item['type'] ?? $item['category'] ?? 'General',
                    'content'        => $item['content'] ?? null,
                    'excerpt'        => $item['description'] ?? null,
                    'image_url'      => $coverUrl,
                    'gallery_uploads'=> $galleryJson,
                    'is_featured'    => false,
                    'is_published'   => true,
                    'published_date' => $publishedDate,
                    'created_at'     => $item['created_at'] ?? now(),
                    'updated_at'     => $item['updated_at'] ?? now(),
                ]
            );
            $this->records++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  → " . count($items) . " news items seeded.\n");
    }

    private function downloadNewsImages(): void
    {
        $this->info('📰 Downloading NEWS images...');
        $data = $this->loadJson('database/data/news.json');
        foreach ($data['value'] ?? [] as $item) {
            foreach (($item['img'] ?? []) as $url) {
                if (str_contains((string)$url, 'supabase')) {
                    $this->downloadImage((string)$url, 'news');
                }
            }
        }
        $this->info("  ✅ News images processed.\n");
    }

    // ════════════════════════════════════════════════════════
    // CULTURE
    // ════════════════════════════════════════════════════════
    private function seedCulture(bool $noImg): void
    {
        $this->info('🎭 Seeding CULTURE EVENTS...');
        $data  = $this->loadJson('database/data/culture.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $idx => $item) {
            $imgUrls    = is_array($item['img']) ? array_filter(array_map('strval', $item['img'])) : [];
            $localPaths = [];
            $coverUrl   = null;

            if (!$noImg && !empty($imgUrls)) {
                foreach ($imgUrls as $url) {
                    $local = $this->downloadImage($url, 'culture');
                    if ($local) {
                        $localPaths[] = $local;
                    }
                }
                $coverUrl = !empty($localPaths)
                    ? Storage::disk('public')->url($localPaths[0])
                    : $imgUrls[0];
            } elseif (!empty($imgUrls)) {
                $coverUrl = $imgUrls[0];
            }

            $galleryJson = !empty($localPaths)
                ? json_encode(array_map(fn($p) => Storage::disk('public')->url($p), $localPaths))
                : (!empty($imgUrls) ? json_encode(array_values($imgUrls)) : null);

            // Use name + year + id to guarantee uniqueness (many events share names across years)
            $slugInput = ($item['name'] ?? 'event') . ' ' . ($item['year'] ?? '') . ' ' . ($item['id'] ?? $idx);
            $slug = Str::slug($slugInput);
            if (empty($slug)) {
                $slug = 'event-' . ($item['id'] ?? $idx);
            }
            $title = $item['name'] ?? ('Culture Event ' . ($idx + 1));

            DB::table('culture_events')->updateOrInsert(
                ['slug' => $slug],
                [
                    'title'           => $title,
                    'slug'            => $slug,
                    'name'            => $item['name'] ?? null,
                    'description'     => $item['description'] ?? null,
                    'category'        => $item['category'] ?? $item['type'] ?? null,
                    'year'            => $item['year'] ?? null,
                    'location'        => $item['location'] ?? null,
                    'sub_category'    => $item['sub_category'] ?? null,
                    'image_url'       => $coverUrl,
                    'gallery_uploads' => $galleryJson,
                    'is_published'    => true,
                    'created_at'      => $item['created_at'] ?? now(),
                    'updated_at'      => $item['updated_at'] ?? now(),
                ]
            );
            $this->records++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  → " . count($items) . " culture events seeded.\n");
    }

    private function downloadCultureImages(): void
    {
        $this->info('🎭 Downloading CULTURE images...');
        $data = $this->loadJson('database/data/culture.json');
        foreach ($data['value'] ?? [] as $item) {
            foreach (($item['img'] ?? []) as $url) {
                if (str_contains((string)$url, 'supabase')) {
                    $this->downloadImage((string)$url, 'culture');
                }
            }
        }
        $this->info("  ✅ Culture images processed.\n");
    }

    // ════════════════════════════════════════════════════════
    // AWARDS
    // ════════════════════════════════════════════════════════
    private function seedAwards(bool $noImg): void
    {
        $this->info('🏆 Seeding AWARDS...');
        $data  = $this->loadJson('database/data/awards.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $idx => $item) {
            $imgUrls    = is_array($item['img']) ? array_filter(array_map('strval', $item['img'])) : [];
            $localPaths = [];
            $coverUrl   = null;

            if (!$noImg && !empty($imgUrls)) {
                foreach ($imgUrls as $url) {
                    $local = $this->downloadImage($url, 'awards');
                    if ($local) {
                        $localPaths[] = $local;
                    }
                }
                $coverUrl = !empty($localPaths)
                    ? Storage::disk('public')->url($localPaths[0])
                    : $imgUrls[0];
            } elseif (!empty($imgUrls)) {
                $coverUrl = $imgUrls[0];
            }

            $galleryJson = !empty($localPaths)
                ? json_encode(array_map(fn($p) => Storage::disk('public')->url($p), $localPaths))
                : (!empty($imgUrls) ? json_encode(array_values($imgUrls)) : null);

            // Parse date
            $awardDate = null;
            if (!empty($item['date'])) {
                try {
                    $awardDate = Carbon::createFromFormat('d/m/Y', $item['date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $awardDate = null;
                }
            }

            DB::table('awards')->updateOrInsert(
                ['title' => $item['title'] ?? 'Award ' . ($idx + 1)],
                [
                    'name'           => $item['title'] ?? $item['name'] ?? 'Award ' . ($idx + 1), // Required col
                    'title'          => $item['title'] ?? null,
                    'issuer'         => $item['issuer'] ?? null,
                    'category'       => $item['cat'] ?? $item['category'] ?? null,
                    'year'           => $item['year'] ?? null,
                    'description'    => $item['description'] ?? null,
                    'award_date'     => $awardDate,
                    'image_url'      => $coverUrl,
                    'gallery_uploads'=> $galleryJson,
                    'is_published'   => true,
                    'created_at'     => $item['created_at'] ?? now(),
                    'updated_at'     => $item['updated_at'] ?? now(),
                ]
            );
            $this->records++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  → " . count($items) . " awards seeded.\n");
    }

    private function downloadAwardImages(): void
    {
        $this->info('🏆 Downloading AWARD images...');
        $data = $this->loadJson('database/data/awards.json');
        foreach ($data['value'] ?? [] as $item) {
            foreach (($item['img'] ?? []) as $url) {
                if (str_contains((string)$url, 'supabase')) {
                    $this->downloadImage((string)$url, 'awards');
                }
            }
        }
        $this->info("  ✅ Award images processed.\n");
    }

    // ════════════════════════════════════════════════════════
    // MEDIA / PRESS
    // ════════════════════════════════════════════════════════
    private function seedMedia(bool $noImg): void
    {
        $this->info('📺 Seeding PRESS COVERAGES...');
        $data  = $this->loadJson('database/data/media.json');
        $items = $data['value'] ?? [];

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $idx => $item) {
            // media.json uses thumbnail_url / clipping_url, not img array
            $imgUrls = [];
            if (!empty($item['thumbnail_url']) && str_contains($item['thumbnail_url'], 'supabase')) {
                $imgUrls[] = $item['thumbnail_url'];
            }
            if (!empty($item['clipping_url']) && str_contains($item['clipping_url'], 'supabase')
                && $item['clipping_url'] !== ($item['thumbnail_url'] ?? '')) {
                $imgUrls[] = $item['clipping_url'];
            }

            $localPaths = [];
            $coverUrl   = null;

            if (!$noImg && !empty($imgUrls)) {
                foreach ($imgUrls as $url) {
                    $local = $this->downloadImage($url, 'press');
                    if ($local) {
                        $localPaths[] = $local;
                    }
                }
                $coverUrl = !empty($localPaths)
                    ? Storage::disk('public')->url($localPaths[0])
                    : $imgUrls[0];
            } elseif (!empty($imgUrls)) {
                $coverUrl = $imgUrls[0];
            }

            DB::table('press_coverages')->updateOrInsert(
                ['headline' => $item['title'] ?? 'Press Coverage ' . ($idx + 1)],
                [
                    'headline'       => $item['title'] ?? 'Press Coverage ' . ($idx + 1),
                    'publication'    => $item['media_source'] ?? null,
                    'external_url'   => $item['clipping_url'] ?? $item['link'] ?? null,
                    'excerpt'        => $item['summary'] ?? $item['description'] ?? null,
                    'image_url'      => $coverUrl,
                    'is_published'   => true,
                    'published_date' => $item['publish_date'] ?? null,
                    'sort_order'     => $item['sort_order'] ?? $idx,
                    'is_featured'    => $item['is_featured'] ?? false,
                    'category'       => $item['category'] ?? null,
                    'created_at'     => $item['created_at'] ?? now(),
                    'updated_at'     => $item['updated_at'] ?? now(),
                ]
            );
            $this->records++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  → " . count($items) . " press coverages seeded.\n");
    }

    private function downloadMediaImages(): void
    {
        $this->info('📺 Downloading PRESS images...');
        $data = $this->loadJson('database/data/media.json');
        foreach ($data['value'] ?? [] as $item) {
            foreach (($item['img'] ?? []) as $url) {
                if (str_contains((string)$url, 'supabase')) {
                    $this->downloadImage((string)$url, 'press');
                }
            }
        }
        $this->info("  ✅ Press images processed.\n");
    }

    // ════════════════════════════════════════════════════════
    // JOB OPENINGS
    // ════════════════════════════════════════════════════════
    private function seedJobs(): void
    {
        $this->info('💼 Seeding JOB OPENINGS...');
        $data  = $this->loadJson('database/data/job_openings.json');
        $items = $data['value'] ?? [];

        foreach ($items as $idx => $item) {
            DB::table('job_openings')->updateOrInsert(
                ['title' => $item['title'] ?? $item['position_title'] ?? 'Opening ' . ($idx + 1)],
                [
                    'title'        => $item['title'] ?? $item['position_title'] ?? 'Job Opening',
                    'department'   => $item['department'] ?? null,
                    'location'     => $item['location'] ?? 'Penang, Malaysia',
                    'type'         => $item['type'] ?? $item['employment_type'] ?? 'Full-time',
                    'description'  => $item['description'] ?? null,
                    'requirements' => $item['requirements'] ?? null,
                    'is_active'    => $item['is_active'] ?? $item['is_available'] ?? true,
                    'is_available' => $item['is_available'] ?? true,
                    'sort_order'   => $item['sort_order'] ?? $idx,
                    'created_at'   => $item['created_at'] ?? now(),
                    'updated_at'   => $item['updated_at'] ?? now(),
                ]
            );
            $this->records++;
        }

        $this->info("  → " . count($items) . " job openings seeded.\n");
    }

    // ════════════════════════════════════════════════════════
    // HELPERS
    // ════════════════════════════════════════════════════════

    /**
     * Download a Supabase image to local public disk storage.
     * Returns the local storage path (relative to public disk), or null on failure.
     */
    private function downloadImage(string $url, string $folder): ?string
    {
        if (!str_contains($url, 'supabase')) {
            return null;
        }

        $filename  = basename(parse_url($url, PHP_URL_PATH));
        $localPath = "supabase/{$folder}/{$filename}";

        // Already exists — skip
        if (Storage::disk('public')->exists($localPath)) {
            $this->imgSkipped++;
            return $localPath;
        }

        try {
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->get($url);

            if ($response->successful() && strlen($response->body()) > 100) {
                Storage::disk('public')->put($localPath, $response->body());
                $this->imgDownloaded++;
                return $localPath;
            } else {
                $this->imgFailed++;
                return null;
            }
        } catch (\Exception $e) {
            $this->imgFailed++;
            return null;
        }
    }

    /**
     * Generate a unique slug for a given table/title combination.
     */
    private function uniqueSlug(string $table, string $title, $suffix = ''): string
    {
        $base = Str::slug($title ?: 'untitled');
        if (empty($base)) {
            $base = 'record';
        }

        $slug = $base;

        // If exists, append suffix (Supabase ID or index)
        if ($suffix && DB::table($table)->where('slug', $slug)->exists()) {
            $slug = $base . '-' . Str::slug((string)$suffix);
        }

        return $slug;
    }

    /**
     * Load and parse a JSON file from the Laravel base path.
     * Handles BOM, CRLF, and whitespace issues.
     */
    private function loadJson(string $relativePath): array
    {
        $path = base_path($relativePath);

        if (!file_exists($path)) {
            $this->error("File not found: $path");
            return ['value' => []];
        }

        $raw = file_get_contents($path);

        // Strip UTF-8 BOM
        $raw = ltrim($raw, "\xEF\xBB\xBF");

        // Normalize line endings
        $raw = str_replace(["\r\n", "\r"], "\n", $raw);

        $decoded = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("JSON parse error in $relativePath: " . json_last_error_msg());
            return ['value' => []];
        }

        return $decoded;
    }
}
