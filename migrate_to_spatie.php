<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

echo "Starting Spatie Media Library Migration...\n\n";

function migrateImage($model, $path, $collection) {
    if (empty($path)) return;
    
    // Check if the path is an external URL
    if (str_starts_with($path, 'http')) {
        try {
            $model->addMediaFromUrl($path)->toMediaCollection($collection);
            echo "  [✓] Migrated URL to $collection: $path\n";
            return true;
        } catch (\Exception $e) {
            echo "  [x] Error migrating URL $path: " . $e->getMessage() . "\n";
            return false;
        }
    }

    // Check if it's a local file in storage/app/public
    $fullPath = storage_path('app/public/' . $path);
    if (file_exists($fullPath)) {
        try {
            // Avoid duplicates by checking if media with same name exists for this model
            $fileName = basename($fullPath);
            $exists = $model->getMedia($collection)->contains(function($media) use ($fileName) {
                return $media->file_name === $fileName;
            });

            if (!$exists) {
                $model->addMedia($fullPath)->preservingOriginal()->toMediaCollection($collection);
                echo "  [✓] Migrated local file to $collection: $path\n";
            } else {
                echo "  [-] Already exists in $collection: $path\n";
            }
            return true;
        } catch (\Exception $e) {
            echo "  [x] Error migrating local file $path: " . $e->getMessage() . "\n";
            return false;
        }
    } else {
        echo "  [!] File not found: $fullPath\n";
        return false;
    }
}

// 1. Projects
echo "--- Projects ---\n";
foreach (App\Models\Project::all() as $p) {
    migrateImage($p, $p->cover_image_upload, 'cover_image');
    if (is_array($p->gallery_uploads)) {
        foreach ($p->gallery_uploads as $img) {
            migrateImage($p, $img, 'gallery');
        }
    }
}

// 2. Awards
echo "\n--- Awards ---\n";
foreach (App\Models\Award::all() as $a) {
    migrateImage($a, $a->logo_upload, 'logo');
    if (is_array($a->gallery_uploads)) {
        foreach ($a->gallery_uploads as $img) {
            migrateImage($a, $img, 'gallery');
        }
    }
}

// 3. News
echo "\n--- News ---\n";
foreach (App\Models\News::all() as $n) {
    migrateImage($n, $n->news_image_upload, 'news_image');
    if (is_array($n->gallery_uploads)) {
        foreach ($n->gallery_uploads as $img) {
            migrateImage($n, $img, 'gallery');
        }
    }
}

// 4. Culture Events
echo "\n--- Culture Events ---\n";
foreach (App\Models\CultureEvent::all() as $e) {
    migrateImage($e, $e->culture_image_upload, 'culture_image');
    if (is_array($e->gallery_uploads)) {
        foreach ($e->gallery_uploads as $img) {
            migrateImage($e, $img, 'gallery');
        }
    }
}

// 5. Press Coverages
echo "\n--- Press Coverages ---\n";
foreach (App\Models\PressCoverage::all() as $pc) {
    migrateImage($pc, $pc->press_image_upload, 'press_image');
    if (is_array($pc->gallery_uploads)) {
        foreach ($pc->gallery_uploads as $img) {
            migrateImage($pc, $img, 'gallery');
        }
    }
}

echo "\nSpatie Migration Complete!\n";
