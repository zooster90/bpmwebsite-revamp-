<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

function downloadFromSupabase($url, $directory) {
    if (!str_contains($url, 'supabase.co')) {
        return $url; // Not a supabase URL, might be already local or other
    }
    
    $filename = basename(parse_url($url, PHP_URL_PATH));
    $path = $directory . '/' . $filename;
    
    if (Storage::disk('public')->exists($path)) {
        return $path;
    }
    
    echo "Downloading $url...\n";
    $response = Http::timeout(30)->get($url);
    if ($response->successful()) {
        Storage::disk('public')->put($path, $response->body());
        return $path;
    }
    
    echo "FAILED to download $url\n";
    return $url;
}

$models = [
    'App\Models\Project' => ['single' => 'cover_image_upload', 'dir' => 'projects'],
    'App\Models\CultureEvent' => ['single' => 'culture_image_upload', 'dir' => 'culture-events'],
    'App\Models\News' => ['single' => 'news_image_upload', 'dir' => 'news'],
    'App\Models\Award' => ['single' => 'award_image_upload', 'dir' => 'awards'],
    'App\Models\PressCoverage' => ['single' => 'press_image_upload', 'dir' => 'press'],
];

foreach ($models as $class => $config) {
    if (!class_exists($class)) continue;
    
    $records = $class::all();
    $count = 0;
    
    foreach ($records as $record) {
        $updated = false;
        
        // Single Image
        if ($record->image_url && str_contains($record->image_url, 'supabase.co')) {
            $localPath = downloadFromSupabase($record->image_url, $config['dir']);
            if ($localPath !== $record->image_url) {
                $record->{$config['single']} = $localPath;
                $record->image_url = null; // Clear old external URL
                $updated = true;
            }
        }
        
        // Gallery
        if ($record->gallery_uploads && is_array($record->gallery_uploads)) {
            $newGallery = [];
            foreach ($record->gallery_uploads as $url) {
                if (str_contains($url, 'supabase.co')) {
                    $localPath = downloadFromSupabase($url, $config['dir']);
                    $newGallery[] = $localPath;
                    if ($localPath !== $url) {
                        $updated = true;
                    }
                } else {
                    $newGallery[] = $url;
                }
            }
            if ($updated) {
                $record->gallery_uploads = $newGallery;
            }
        }
        
        if ($updated) {
            // Disable activity log recording for this mass update to save time and space
            $record->disableLogging(); 
            $record->save();
            $count++;
        }
    }
    
    echo "$class: Updated $count records.\n";
}

echo "Supabase migration completed.\n";
