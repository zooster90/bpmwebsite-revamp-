<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$db = DB::connection();
echo "=== MIGRATION VERIFICATION ===\n\n";

$projects = DB::table('projects')->count();
$projectsWithImg = DB::table('projects')->whereNotNull('image_url')->where('image_url', '!=', '')->count();
echo "Projects total:      $projects\n";
echo "Projects with image: $projectsWithImg\n";
$sample = DB::table('projects')->whereNotNull('image_url')->first();
echo "Sample image URL: " . ($sample->image_url ?? 'NONE') . "\n\n";

$news = DB::table('news')->count();
$newsWithImg = DB::table('news')->whereNotNull('image_url')->where('image_url', '!=', '')->count();
echo "News total:      $news\n";
echo "News with image: $newsWithImg\n\n";

$culture = DB::table('culture_events')->count();
$cultureWithImg = DB::table('culture_events')->whereNotNull('image_url')->where('image_url', '!=', '')->count();
echo "Culture events total:      $culture\n";
echo "Culture events with image: $cultureWithImg\n\n";

$awards = DB::table('awards')->count();
$awardsWithImg = DB::table('awards')->whereNotNull('image_url')->where('image_url', '!=', '')->count();
echo "Awards total:      $awards\n";
echo "Awards with image: $awardsWithImg\n\n";

$press = DB::table('press_coverages')->count();
$pressWithImg = DB::table('press_coverages')->whereNotNull('image_url')->where('image_url', '!=', '')->count();
echo "Press total:      $press\n";
echo "Press with image: $pressWithImg\n\n";

// Check local file existence
$sampleLocal = DB::table('projects')->whereNotNull('image_url')->where('image_url', 'like', '%/storage/supabase/%')->first();
if ($sampleLocal) {
    $path = str_replace('/storage/', storage_path('app/public/'), $sampleLocal->image_url);
    $path = preg_replace('/^.*\/storage\/supabase\//', storage_path('app/public/supabase/'), $sampleLocal->image_url);
    echo "Local image check:\n";
    echo "  URL: " . $sampleLocal->image_url . "\n";
    
    // Count local files in storage
    $count = 0;
    foreach (['projects', 'news', 'culture', 'awards', 'press'] as $folder) {
        $dir = storage_path("app/public/supabase/$folder");
        if (is_dir($dir)) {
            $files = glob("$dir/*");
            $count += count($files);
            echo "  Local $folder files: " . count($files) . "\n";
        }
    }
    echo "\nTotal local files: $count\n";
}
