<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Award URL Sample: " . App\Models\Award::whereNotNull('image_url')->value('image_url') . "\n";
echo "News URL Sample: " . App\Models\News::whereNotNull('image_url')->value('image_url') . "\n";
echo "Culture URL Sample: " . App\Models\CultureEvent::whereNotNull('image_url')->value('image_url') . "\n";
echo "Press URL Sample: " . App\Models\PressCoverage::whereNotNull('image_url')->value('image_url') . "\n";
