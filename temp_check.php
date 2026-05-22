<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$settings = \App\Models\Setting::all();
foreach($settings as $s) {
    echo "ID: {$s->id} | Key: {$s->key} | Label: {$s->label} | Group: {$s->group} | Type: {$s->type}\n";
}
unlink(__FILE__);
