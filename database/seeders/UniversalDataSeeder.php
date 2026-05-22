<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Project;
use App\Models\Award;
use App\Models\News;
use App\Models\CultureEvent;
use App\Models\PressCoverage;
use App\Models\JobOpening;
use Carbon\Carbon;

class UniversalDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting Enterprise Data Import...');

        // 1. Projects
        $this->importProjects();

        // 2. Awards
        $this->importAwards();

        // 3. News
        $this->importNews();

        // 4. Media (Press Coverage)
        $this->importMedia();

        // 5. Culture
        $this->importCulture();

        // 6. Job Openings
        $this->importJobs();

        $this->command->info('✅ All records imported successfully!');
    }

    private function getJsonData($filename)
    {
        // Try multiple possible paths to find the data
        $paths = [
            database_path('data/' . $filename),
            base_path('../Design/builtech-app/database/data/' . $filename),
            'C:/Users/built/Downloads/Design (3) (2)/Design (2) (2)/Design (8)/Design/builtech-app/database/data/' . $filename,
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                $content = file_get_contents($path);
                $data = json_decode($content, true);
                return $data['value'] ?? $data;
            }
        }

        $this->command->warn("⚠️ File not found: $filename");
        return [];
    }

    private function importProjects()
    {
        $records = $this->getJsonData('projects.json');
        $count = 0;
        foreach ($records as $r) {
            Project::updateOrCreate(
                ['slug' => $r['slug'] ?? Str::slug($r['title'])],
                [
                    'name'         => $r['title'],
                    'description'  => $r['description'] ?? null,
                    'location'     => $r['loc'] ?? null,
                    'category'     => $r['cat'] ?? null,
                    'status'       => $r['status'] ?? 'Completed',
                    'year'         => $r['year'] ?? null,
                    'image_url'    => !empty($r['img']) ? $r['img'][0] : null,
                    'award'        => $r['award'] ?? null,
                    'is_flagship'  => $r['is_flagship'] ?? false,
                    'is_published' => true,
                ]
            );
            $count++;
        }
        $this->command->info("📦 Imported $count Projects.");
    }

    private function importAwards()
    {
        $records = $this->getJsonData('awards.json');
        $count = 0;
        foreach ($records as $r) {
            Award::updateOrCreate(
                ['name' => $r['title'], 'year' => $r['year']],
                [
                    'issuer'      => $r['issuer'] ?? null,
                    'description' => $r['description'] ?? null,
                    'category'    => $r['cat'] ?? null,
                    'image_url'   => !empty($r['img']) ? $r['img'][0] : null,
                ]
            );
            $count++;
        }
        $this->command->info("🏆 Imported $count Awards.");
    }

    private function importNews()
    {
        $records = $this->getJsonData('news.json');
        $count = 0;
        foreach ($records as $r) {
            // Parse date if possible
            $publishedDate = null;
            if (!empty($r['date'])) {
                try {
                    $publishedDate = Carbon::createFromFormat('d/m/Y', $r['date']);
                } catch (\Exception $e) {
                    $publishedDate = now();
                }
            }

            News::updateOrCreate(
                ['title' => $r['title'], 'published_date' => $publishedDate],
                [
                    'slug'           => Str::slug($r['title']),
                    'content'        => $r['content'] ?? $r['description'] ?? null,
                    'category'       => $r['category'] ?? $r['type'] ?? null,
                    'image_url'      => !empty($r['img']) ? $r['img'][0] : null,
                    'is_published'   => true,
                    'published_date' => $publishedDate,
                ]
            );
            $count++;
        }
        $this->command->info("📰 Imported $count News records.");
    }

    private function importMedia()
    {
        $records = $this->getJsonData('media.json');
        $count = 0;
        foreach ($records as $r) {
            $publishedDate = null;
            if (!empty($r['date'])) {
                try {
                    $publishedDate = Carbon::createFromFormat('d/m/Y', $r['date']);
                } catch (\Exception $e) {
                    $publishedDate = now();
                }
            }

            PressCoverage::updateOrCreate(
                ['headline' => $r['title'], 'published_date' => $publishedDate],
                [
                    'publication'    => $r['publisher'] ?? 'Builtech Media',
                    'external_url'   => $r['link'] ?? null,
                    'excerpt'        => $r['description'] ?? null,
                    'image_url'      => !empty($r['img']) ? $r['img'][0] : null,
                ]
            );
            $count++;
        }
        $this->command->info("📺 Imported $count Press Coverage records.");
    }

    private function importCulture()
    {
        $records = $this->getJsonData('culture.json');
        $count = 0;
        foreach ($records as $r) {
            CultureEvent::updateOrCreate(
                ['title' => $r['title']],
                [
                    'slug'        => Str::slug($r['title']),
                    'description' => $r['description'] ?? null,
                    'event_date'  => isset($r['year']) ? Carbon::create($r['year'], 1, 1) : null,
                    'category'    => $r['cat'] ?? null,
                    'image_url'   => !empty($r['img']) ? $r['img'][0] : null,
                ]
            );
            $count++;
        }
        $this->command->info("🎭 Imported $count Culture Events.");
    }

    private function importJobs()
    {
        $records = $this->getJsonData('job_openings.json');
        $count = 0;
        foreach ($records as $r) {
            JobOpening::updateOrCreate(
                ['title' => $r['title']],
                [
                    'description'  => $r['description'] ?? null,
                    'requirements' => $r['requirements'] ?? null,
                    'location'     => $r['location'] ?? 'Penang, Malaysia',
                    'is_active'    => true,
                ]
            );
            $count++;
        }
        $this->command->info("💼 Imported $count Job Openings.");
    }
}
