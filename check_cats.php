<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

echo "=== ALL PROJECTS & THEIR CATEGORIES ===\n";
$projects = Project::with('category')->get();
foreach ($projects as $p) {
    echo "ID: {$p->id} | Name: {$p->name} | Category ID: {$p->category_id} | Cat Name: " . ($p->category ? $p->category->name : 'NONE') . " | Cat Slug: " . ($p->category ? $p->category->slug : 'NONE') . "\n";
}
