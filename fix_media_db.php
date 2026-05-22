<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$affected1 = DB::table('media')->whereNull('disk')->update(['disk' => 'public']);
$affected2 = DB::table('media')->whereNull('conversions_disk')->update(['conversions_disk' => 'public']);

echo "Fixed $affected1 NULL disks.\n";
echo "Fixed $affected2 NULL conversions_disks.\n";

$m = \Spatie\MediaLibrary\MediaCollections\Models\Media::select('model_type', 'collection_name')
    ->selectRaw('count(*) as count')
    ->groupBy('model_type', 'collection_name')
    ->get();
print_r($m->toArray());
