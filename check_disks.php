<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$disks = \Illuminate\Support\Facades\DB::table('media')->select('disk', 'conversions_disk')->distinct()->get();
print_r($disks->toArray());
