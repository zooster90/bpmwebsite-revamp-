<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

echo "Checking gallery_uploads for Supabase images...\n";

function downloadGalleryImage($url, $directory) {
    if (empty($url) || !str_starts_with($url, 'http')) {
        return $url; // Return original if not external URL
    }
    
    try {
        $context = stream_context_create(["ssl" => ["verify_peer" => false, "verify_peer_name" => false]]);
        $content = @file_get_contents($url, false, $context);
        
        if ($content === false) return $url; // Failed, keep original

        $ext = 'jpg';
        if (preg_match('/\.([a-z0-9]+)(?:[\?#]|$)/i', $url, $matches)) {
            $ext = strtolower($matches[1]);
        }
        $filename = Str::random(20) . '.' . $ext;
        $path = $directory . '/' . $filename;

        Storage::disk('public')->put($path, $content);
        echo "  [✓] Downloaded gallery image to: $path\n";
        return $path;
    } catch (\Exception $e) {
        return $url;
    }
}

$tables = [
    'projects' => [\App\Models\Project::class, 'project-galleries'],
    'awards' => [\App\Models\Award::class, 'award-galleries'],
    'news' => [\App\Models\News::class, 'news-gallery'],
    'culture_events' => [\App\Models\CultureEvent::class, 'culture-galleries']
];

$totalDownloaded = 0;

foreach($tables as $name => [$class, $dir]) {
    if(!class_exists($class)) continue;
    
    $records = $class::whereNotNull('gallery_uploads')->get();
    foreach($records as $r) {
        $gallery = $r->gallery_uploads;
        if (is_string($gallery)) $gallery = json_decode($gallery, true);
        if (!is_array($gallery)) continue;
        
        $updated = false;
        $newGallery = [];
        
        foreach($gallery as $imgUrl) {
            if (is_string($imgUrl) && str_starts_with($imgUrl, 'http')) {
                echo "Downloading from $name ID {$r->id}: $imgUrl\n";
                $localPath = downloadGalleryImage($imgUrl, $dir);
                if ($localPath !== $imgUrl) {
                    $updated = true;
                    $totalDownloaded++;
                    $newGallery[] = $localPath;
                } else {
                    $newGallery[] = $imgUrl; // Keep original if failed
                }
            } else {
                $newGallery[] = $imgUrl;
            }
        }
        
        if ($updated) {
            $r->gallery_uploads = $newGallery;
            $r->save();
        }
    }
}

echo "Total gallery images downloaded: $totalDownloaded\n";

// Also check Spatie MediaLibrary
$media = \App\Models\Media::where('disk', '!=', 'public')->get();
echo "External Spatie Media items: " . $media->count() . "\n";
