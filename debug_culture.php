<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CultureEvent;
use App\Models\News;
use App\Models\Award;
use App\Models\PressCoverage;

echo "=== DEBUG: CultureEvent sample ===\n";
$e = CultureEvent::where('image_url', 'like', '%supabase%')->first();
if ($e) {
    echo "ID: " . $e->id . "\n";
    echo "image_url: " . $e->image_url . "\n";
    $gallery = $e->gallery_uploads;
    echo "gallery_uploads type: " . gettype($gallery) . "\n";
    if (is_array($gallery)) {
        echo "gallery count: " . count($gallery) . "\n";
        foreach (array_slice($gallery, 0, 2) as $url) {
            echo "  gallery sample: " . $url . "\n";
        }
    } else {
        echo "gallery raw: " . substr($gallery ?? 'NULL', 0, 200) . "\n";
    }
} else {
    echo "No CultureEvent with supabase URL found!\n";
}

echo "\n=== DEBUG: News sample ===\n";
$n = News::where('image_url', 'like', '%supabase%')->first();
if ($n) {
    echo "ID: " . $n->id . "\n";
    echo "image_url: " . $n->image_url . "\n";
    $gallery = $n->gallery_uploads;
    echo "gallery_uploads type: " . gettype($gallery) . "\n";
    if (is_array($gallery)) {
        echo "gallery count: " . count($gallery) . "\n";
    }
} else {
    echo "No News with supabase URL. Checking gallery_uploads...\n";
    $n2 = News::whereNotNull('gallery_uploads')->first();
    if ($n2) {
        echo "First News with gallery_uploads:\n";
        echo "  image_url: " . $n2->image_url . "\n";
        $g = $n2->gallery_uploads;
        if (is_array($g)) {
            foreach (array_slice($g, 0, 2) as $u) {
                echo "  gallery: $u\n";
            }
        }
    }
}

echo "\n=== COUNTS ===\n";
echo "CultureEvent total: " . CultureEvent::count() . "\n";
echo "CultureEvent with supabase image_url: " . CultureEvent::where('image_url', 'like', '%supabase%')->count() . "\n";
echo "CultureEvent with non-null gallery_uploads: " . CultureEvent::whereNotNull('gallery_uploads')->count() . "\n";

echo "\nNews total: " . News::count() . "\n";
echo "News with supabase image_url: " . News::where('image_url', 'like', '%supabase%')->count() . "\n";

echo "\nAward total: " . Award::count() . "\n";
echo "Award with supabase image_url: " . Award::where('image_url', 'like', '%supabase%')->count() . "\n";

echo "\nPressCoverage total: " . PressCoverage::count() . "\n";
echo "PressCoverage with supabase image_url: " . PressCoverage::where('image_url', 'like', '%supabase%')->count() . "\n";
