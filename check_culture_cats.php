<?php
// Run: php check_categories.php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ALL CultureEvent Categories ===\n\n";
$cats = App\Models\Category::where('model_type','CultureEvent')
    ->orderBy('parent_id')
    ->orderBy('name')
    ->get();

foreach ($cats as $c) {
    $count = App\Models\CultureEvent::where('category_id', $c->id)->count();
    $subCount = App\Models\CultureEvent::where('sub_category_id', $c->id)->count();
    $parent = $c->parent_id ? "(sub of #{$c->parent_id})" : "(TOP LEVEL)";
    echo "ID:{$c->id} | '{$c->name}' | slug:'{$c->slug}' | {$parent} | events:{$count} | as_subcat:{$subCount}\n";
}

echo "\n=== DUPLICATES (same name, top-level) ===\n";
$dupes = App\Models\Category::where('model_type','CultureEvent')
    ->whereNull('parent_id')
    ->get()
    ->groupBy('name')
    ->filter(fn($g) => $g->count() > 1);
foreach ($dupes as $name => $group) {
    echo "DUPLICATE NAME: '$name'\n";
    foreach ($group as $c) {
        $count = App\Models\CultureEvent::where('category_id', $c->id)->count();
        echo "  -> ID:{$c->id} slug:'{$c->slug}' events:{$count}\n";
    }
}
