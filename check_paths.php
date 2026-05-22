<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Culture Image Path Sample: " . App\Models\CultureEvent::whereNotNull('culture_image_upload')->value('culture_image_upload') . "\n";
echo "News Image Path Sample: " . App\Models\News::whereNotNull('news_image_upload')->value('news_image_upload') . "\n";
echo "Press Image Path Sample: " . App\Models\PressCoverage::whereNotNull('press_image_upload')->value('press_image_upload') . "\n";
