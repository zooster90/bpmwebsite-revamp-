<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = ['projects' => \App\Models\Project::class, 'awards' => \App\Models\Award::class, 'news' => \App\Models\News::class, 'culture_events' => \App\Models\CultureEvent::class];
foreach($tables as $name => $class) {
    if(!class_exists($class)) continue;
    $hasUrl = $class::whereNotNull('image_url')->where('image_url', '!=', '')->count();
    $uploadCol = $name == 'projects' ? 'cover_image_upload' : ($name == 'awards' ? 'logo_upload' : ($name == 'news' ? 'news_image_upload' : 'culture_image_upload'));
    $hasUpload = $class::whereNotNull($uploadCol)->where($uploadCol, '!=', '')->count();
    echo "$name -> image_url: $hasUrl, $uploadCol: $hasUpload\n";
    if($hasUrl > 0) {
        $first = $class::whereNotNull('image_url')->where('image_url', '!=', '')->first();
        echo "  Sample URL: " . $first->image_url . "\n";
    }
}
