<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\MediaLibrary\MediaCollections\Models\Media;

$mediaItems = Media::latest()->take(5)->get();

echo "Checking last 5 media items:\n";
foreach ($mediaItems as $media) {
    echo "ID: {$media->id} | Disk: {$media->disk} | Collection: {$media->collection_name} | File: {$media->file_name}\n";
    echo "URL: " . $media->getUrl() . "\n";
    echo "Path: " . $media->getPath() . "\n";
    echo "Exists on disk: " . (file_exists($media->getPath()) ? 'YES' : 'NO') . "\n";
    echo "-------------------\n";
}
