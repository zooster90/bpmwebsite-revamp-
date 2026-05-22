<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function countHttp($model) {
    return $model::where('image_url', 'like', 'http%')->count();
}
function countLocal($model, $col) {
    return $model::whereNotNull($col)->count();
}

echo "Projects: HTTP=" . countHttp('App\Models\Project') . ", Local=" . countLocal('App\Models\Project', 'cover_image_upload') . "\n";
echo "Awards: HTTP=" . countHttp('App\Models\Award') . ", Local=" . countLocal('App\Models\Award', 'logo_upload') . "\n";
echo "News: HTTP=" . countHttp('App\Models\News') . ", Local=" . countLocal('App\Models\News', 'news_image_upload') . "\n";
echo "Culture: HTTP=" . countHttp('App\Models\CultureEvent') . ", Local=" . countLocal('App\Models\CultureEvent', 'culture_image_upload') . "\n";
echo "Press: HTTP=" . countHttp('App\Models\PressCoverage') . ", Local=" . countLocal('App\Models\PressCoverage', 'press_image_upload') . "\n";
