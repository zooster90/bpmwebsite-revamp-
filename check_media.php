<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$m = \Spatie\MediaLibrary\MediaCollections\Models\Media::select('model_type', 'collection_name')
    ->selectRaw('count(*) as count')
    ->groupBy('model_type', 'collection_name')
    ->get();

foreach($m as $row) {
    echo $row->model_type . " | " . $row->collection_name . " | " . $row->count . "\n";
}
