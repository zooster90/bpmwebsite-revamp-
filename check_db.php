<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Media count: " . \Spatie\MediaLibrary\MediaCollections\Models\Media::count() . "\n";
$firstMedia = \Spatie\MediaLibrary\MediaCollections\Models\Media::first();
if ($firstMedia) {
    echo "First media file_name: " . $firstMedia->file_name . "\n";
    echo "First media path: " . $firstMedia->getPath() . "\n";
}

echo "Projects with cover_image_upload: " . \App\Models\Project::whereNotNull('cover_image_upload')->count() . "\n";
$p = \App\Models\Project::whereNotNull('cover_image_upload')->first();
if ($p) {
    echo "Project cover_image_upload value: " . $p->cover_image_upload . "\n";
}

echo "News with news_image_upload: " . \App\Models\News::whereNotNull('news_image_upload')->count() . "\n";
$n = \App\Models\News::whereNotNull('news_image_upload')->first();
if ($n) {
    echo "News news_image_upload value: " . $n->news_image_upload . "\n";
}
