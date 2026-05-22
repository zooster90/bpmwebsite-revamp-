<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use App\Models\Award;
use App\Models\News;
use App\Models\CultureEvent;
use App\Models\PressCoverage;

$models = [
    'Project' => Project::class,
    'Award' => Award::class,
    'News' => News::class,
    'CultureEvent' => CultureEvent::class,
    'PressCoverage' => PressCoverage::class,
];

foreach ($models as $name => $class) {
    $count = $class::where('image_url', 'like', '%supabase%')->count();
    echo "$name: $count Supabase images found.\n";
    
    // Also check gallery fields if they are JSON
    if ($name === 'Project' || $name === 'Award' || $name === 'CultureEvent' || $name === 'PressCoverage') {
        // This is harder to query directly with 'like' if it's JSON, 
        // but we can check if the field exists and has content.
    }
}
