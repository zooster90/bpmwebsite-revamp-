<?php

/**
 * ╔══════════════════════════════════════════════════════════════════════╗
 * ║   Supabase to Local Storage Migrator                                 ║
 * ║   ─────────────────────────────────────────────────────────────────  ║
 * ║   1. Finds Supabase URLs in image_url and gallery_uploads            ║
 * ║   2. Downloads them to storage/app/public/migrations/...             ║
 * ║   3. Updates database 'upload' fields for permanent local storage    ║
 * ╚══════════════════════════════════════════════════════════════════════╝
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Project;
use App\Models\Award;
use App\Models\News;
use App\Models\CultureEvent;
use App\Models\PressCoverage;

$models = [
    'Project'       => ['class' => Project::class,      'upload_field' => 'cover_image_upload', 'dir' => 'projects'],
    'Award'         => ['class' => Award::class,        'upload_field' => 'logo_upload',        'dir' => 'awards'],
    'News'          => ['class' => News::class,         'upload_field' => 'news_image_upload',  'dir' => 'news'],
    'CultureEvent'  => ['class' => CultureEvent::class,  'upload_field' => 'culture_image_upload','dir' => 'culture'],
    'PressCoverage' => ['class' => PressCoverage::class, 'upload_field' => 'press_image_upload', 'dir' => 'press'],
];

echo "🚀 Starting Supabase Asset Migration...\n";
echo "------------------------------------------\n";

foreach ($models as $name => $meta) {
    $class = $meta['class'];
    $uploadField = $meta['upload_field'];
    $subDir = $meta['dir'];
    
    echo "🔍 Checking $name...\n";
    
    $records = $class::all();
    $migratedCount = 0;
    
    foreach ($records as $record) {
        $updated = false;
        
        // 1. Process Main Image URL
        if ($record->image_url && str_contains($record->image_url, 'supabase') && empty($record->$uploadField)) {
            $url = $record->image_url;
            $filename = basename(parse_url($url, PHP_URL_PATH));
            $safeName = time() . '_' . Str::random(8) . '_' . $filename;
            $localPath = "migrations/{$subDir}/{$safeName}";
            
            try {
                echo "   📥 Downloading main image: $filename\n";
                $content = @file_get_contents($url);
                if ($content) {
                    Storage::disk('public')->put($localPath, $content);
                    $record->$uploadField = $localPath;
                    $updated = true;
                    $migratedCount++;
                }
            } catch (\Exception $e) {
                echo "   ❌ Error downloading $url: " . $e->getMessage() . "\n";
            }
        }
        
        // 2. Process Gallery Uploads (JSON/Array)
        if (isset($record->gallery_uploads) && is_array($record->gallery_uploads)) {
            $newGallery = [];
            $galleryUpdated = false;
            
            foreach ($record->gallery_uploads as $url) {
                if (is_string($url) && str_contains($url, 'supabase')) {
                    $filename = basename(parse_url($url, PHP_URL_PATH));
                    $safeName = time() . '_' . Str::random(8) . '_' . $filename;
                    $localPath = "migrations/{$subDir}/gallery/{$safeName}";
                    
                    try {
                        echo "   📥 Downloading gallery item: $filename\n";
                        $content = @file_get_contents($url);
                        if ($content) {
                            Storage::disk('public')->put($localPath, $content);
                            $newGallery[] = $localPath;
                            $galleryUpdated = true;
                            $migratedCount++;
                        } else {
                            $newGallery[] = $url; // Keep old URL if download fails
                        }
                    } catch (\Exception $e) {
                        echo "   ❌ Error downloading gallery item $url\n";
                        $newGallery[] = $url;
                    }
                } else {
                    $newGallery[] = $url;
                }
            }
            
            if ($galleryUpdated) {
                $record->gallery_uploads = $newGallery;
                $updated = true;
            }
        }
        
        if ($updated) {
            $record->save();
        }
    }
    
    echo "✅ Finished $name: $migratedCount assets migrated.\n\n";
}

echo "------------------------------------------\n";
echo "🎉 Migration Complete!\n";
echo "💡 Tip: Run 'php artisan storage:link' if you haven't already.\n";
