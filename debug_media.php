<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

$media = Media::limit(10)->get()->map(function($m) {
    return [
        'id' => $m->id,
        'model' => $m->model_type,
        'collection' => $m->collection_name,
        'name' => $m->name,
        'file' => $m->file_name,
        'disk' => $m->disk,
        'size' => $m->size,
        'url' => $m->getUrl(),
        'path' => $m->getPath(),
        'exists' => file_exists($m->getPath()),
    ];
});

header('Content-Type: application/json');
echo json_encode($media, JSON_PRETTY_PRINT);
