<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\News;
use App\Models\Award;
use App\Models\CultureEvent;
use App\Models\PressCoverage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrateSupabaseMedia extends Command
{
    protected $signature = 'app:migrate-supabase-media {--force : Force migration even if media already exists}';
    protected $description = 'Downloads images from Supabase URLs and attaches them to Spatie Media Library';

    public function handle()
    {
        $this->info('🚀 Starting Supabase Media Migration...');

        // 🛠️ Repair step: Ensure all media records have a valid disk
        $this->fixMediaTable();

        $this->migrateProjects();
        $this->migrateNews();
        $this->migrateAwards();
        $this->migrateCulture();
        $this->migratePress();

        $this->info('✅ Migration Complete!');
    }

    protected function fixMediaTable()
    {
        $this->comment('Checking media table for disk consistency...');
        $count = DB::table('media')->whereNull('disk')->update(['disk' => 'public']);
        if ($count > 0) {
            $this->warn("⚙️ Fixed {$count} media records with missing disk assignment.");
        }
    }

    protected function migrateProjects()
    {
        $this->info('--- Migrating Projects ---');
        Project::all()->each(function ($item) {
            // Cover Image
            if ($item->image_url && (str_contains($item->image_url, 'supabase') || str_starts_with($item->image_url, 'http'))) {
                if ($this->option('force') || !$item->hasMedia('cover_image')) {
                    $this->downloadAndAttach($item, $item->image_url, 'cover_image');
                }
            }
            // Gallery
            if (is_array($item->gallery_uploads)) {
                foreach ($item->gallery_uploads as $url) {
                    if (str_contains($url, 'supabase') || str_starts_with($url, 'http')) {
                        $this->downloadAndAttach($item, $url, 'gallery');
                    }
                }
            }
        });
    }

    protected function migrateNews()
    {
        $this->info('--- Migrating News ---');
        News::all()->each(function ($item) {
            if ($item->image_url && (str_contains($item->image_url, 'supabase') || str_starts_with($item->image_url, 'http'))) {
                if ($this->option('force') || !$item->hasMedia('news_image')) {
                    $this->downloadAndAttach($item, $item->image_url, 'news_image');
                }
            }
            if (is_array($item->gallery_uploads)) {
                foreach ($item->gallery_uploads as $url) {
                    if (str_contains($url, 'supabase') || str_starts_with($url, 'http')) {
                        $this->downloadAndAttach($item, $url, 'gallery');
                    }
                }
            }
        });
    }

    protected function migrateAwards()
    {
        $this->info('--- Migrating Awards ---');
        Award::all()->each(function ($item) {
            if ($item->image_url && (str_contains($item->image_url, 'supabase') || str_starts_with($item->image_url, 'http'))) {
                if ($this->option('force') || !$item->hasMedia('logo')) {
                    $this->downloadAndAttach($item, $item->image_url, 'logo');
                }
            }
            if (is_array($item->gallery_uploads)) {
                foreach ($item->gallery_uploads as $url) {
                    if (str_contains($url, 'supabase') || str_starts_with($url, 'http')) {
                        $this->downloadAndAttach($item, $url, 'gallery');
                    }
                }
            }
        });
    }

    protected function migrateCulture()
    {
        $this->info('--- Migrating Culture Events ---');
        CultureEvent::all()->each(function ($item) {
            if ($item->image_url && (str_contains($item->image_url, 'supabase') || str_starts_with($item->image_url, 'http'))) {
                if ($this->option('force') || !$item->hasMedia('culture_image')) {
                    $this->downloadAndAttach($item, $item->image_url, 'culture_image');
                }
            }
            if (is_array($item->gallery_uploads)) {
                foreach ($item->gallery_uploads as $url) {
                    if (str_contains($url, 'supabase') || str_starts_with($url, 'http')) {
                        $this->downloadAndAttach($item, $url, 'gallery');
                    }
                }
            }
        });
    }

    protected function migratePress()
    {
        $this->info('--- Migrating Press Coverage ---');
        PressCoverage::all()->each(function ($item) {
            if ($item->image_url && (str_contains($item->image_url, 'supabase') || str_starts_with($item->image_url, 'http'))) {
                if ($this->option('force') || !$item->hasMedia('press_image')) {
                    $this->downloadAndAttach($item, $item->image_url, 'press_image');
                }
            }
        });
    }

    protected function downloadAndAttach($model, $url, $collection)
    {
        try {
            $url = $this->ensureFullUrl($url);
            
            if (!$url) return;

            $this->comment("Downloading: {$url}");
            
            // Extract filename from URL
            $filename = basename(parse_url($url, PHP_URL_PATH));
            if (!$filename || !str_contains($filename, '.')) {
                $filename = Str::random(10) . '.jpg';
            }

            // Using Spatie's helper which handles download automatically
            $model->addMediaFromUrl($url)
                  ->usingFileName($filename)
                  ->toMediaCollection($collection);
            
            $this->info("✅ Attached to {$collection}");

        } catch (\Exception $e) {
            $this->error("❌ Error migrating {$url}: " . $e->getMessage());
        }
    }

    protected function ensureFullUrl($url)
    {
        if (empty($url)) return null;

        // 1. If it's already a full URL, return it
        if (str_starts_with($url, 'http')) {
            return $url;
        }

        // 2. Base Supabase Public Storage URL for the project
        // The project-images bucket seems to contain subfolders like /culture, /news, etc.
        $baseUrl = 'https://guvifomiadxehmtrqrfu.supabase.co/storage/v1/object/public/project-images/';

        // 3. Handle 'supabase/' prefix often found in legacy database strings
        // Example: 'supabase/culture/img.jpg' -> 'culture/img.jpg'
        if (str_starts_with($url, 'supabase/')) {
            $url = Str::after($url, 'supabase/');
        }

        // 4. Ensure we don't have leading slashes
        $url = ltrim($url, '/');

        // 5. Final Assembly
        return $baseUrl . $url;
    }
}
