<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Projects with gallery_uploads: " . \App\Models\Project::whereNotNull('gallery_uploads')->count() . "\n";
$p = \App\Models\Project::whereNotNull('gallery_uploads')->first();
if ($p) {
    print_r($p->gallery_uploads);
}
