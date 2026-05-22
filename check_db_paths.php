<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Award;
use App\Models\Project;

echo "--- Awards ---\n";
$awards = Award::whereNotNull('image_url')->orWhereNotNull('logo_upload')->take(5)->get();
foreach($awards as $a) {
    echo "ID: {$a->id} | Name: {$a->name}\n";
    echo "  image_url: " . ($a->image_url ?? 'NULL') . "\n";
    echo "  logo_upload: " . ($a->logo_upload ?? 'NULL') . "\n";
}

echo "\n--- Projects ---\n";
$projects = Project::whereNotNull('image_url')->orWhereNotNull('cover_image_upload')->take(5)->get();
foreach($projects as $p) {
    echo "ID: {$p->id} | Name: {$p->name}\n";
    echo "  image_url: " . ($p->image_url ?? 'NULL') . "\n";
    echo "  cover_image_upload: " . ($p->cover_image_upload ?? 'NULL') . "\n";
}
