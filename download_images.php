<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

echo "Starting Image Migration from Supabase to Local Storage...\n\n";

function downloadAndSaveImage($url, $directory) {
    if (empty($url) || !str_starts_with($url, 'http')) {
        return null; // Not an external URL
    }
    
    try {
        // Fetch image content
        $context = stream_context_create([
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ]
        ]);
        $content = @file_get_contents($url, false, $context);
        
        if ($content === false) {
            echo "  [x] Failed to download: $url\n";
            return null;
        }

        // Determine extension from URL or content
        $ext = 'jpg';
        if (preg_match('/\.([a-z0-9]+)(?:[\?#]|$)/i', $url, $matches)) {
            $ext = strtolower($matches[1]);
        }
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            $ext = 'jpg';
        }

        // Generate safe filename
        $filename = Str::random(20) . '.' . $ext;
        $path = $directory . '/' . $filename;

        // Save to public disk
        Storage::disk('public')->put($path, $content);
        
        echo "  [✓] Downloaded and saved as: $path\n";
        return $path;
        
    } catch (\Exception $e) {
        echo "  [x] Error downloading $url: " . $e->getMessage() . "\n";
        return null;
    }
}

// 1. Projects
echo "--- Migrating Projects ---\n";
$projects = App\Models\Project::whereNotNull('image_url')->whereNull('cover_image_upload')->get();
foreach ($projects as $p) {
    echo "Processing Project ID {$p->id}: {$p->name}\n";
    $localPath = downloadAndSaveImage($p->image_url, 'project-covers');
    if ($localPath) {
        $p->cover_image_upload = $localPath;
        $p->save();
    }
}

// 2. Awards
echo "\n--- Migrating Awards ---\n";
$awards = App\Models\Award::whereNotNull('image_url')->whereNull('logo_upload')->get();
foreach ($awards as $a) {
    // Only try to download if it's an external URL (not our local fallback '/images/...')
    if (str_starts_with($a->image_url, 'http')) {
        echo "Processing Award ID {$a->id}: {$a->name}\n";
        $localPath = downloadAndSaveImage($a->image_url, 'award-logos');
        if ($localPath) {
            $a->logo_upload = $localPath;
            $a->save();
        }
    }
}

// 3. News
echo "\n--- Migrating News ---\n";
$news = App\Models\News::whereNotNull('image_url')->whereNull('news_image_upload')->get();
foreach ($news as $n) {
    echo "Processing News ID {$n->id}: {$n->title}\n";
    $localPath = downloadAndSaveImage($n->image_url, 'news-images');
    if ($localPath) {
        $n->news_image_upload = $localPath;
        $n->save();
    }
}

// 4. Culture Events
echo "\n--- Migrating Culture Events ---\n";
// Ensure CultureEvent model exists before querying
if (class_exists('App\Models\CultureEvent')) {
    $events = App\Models\CultureEvent::whereNotNull('image_url')->whereNull('culture_image_upload')->get();
    foreach ($events as $e) {
        echo "Processing Culture Event ID {$e->id}: {$e->name}\n";
        $localPath = downloadAndSaveImage($e->image_url, 'culture-images');
        if ($localPath) {
            $e->culture_image_upload = $localPath;
            $e->save();
        }
    }
}

echo "\nMigration Complete! All Supabase images have been downloaded to your local Laravel storage.\n";
