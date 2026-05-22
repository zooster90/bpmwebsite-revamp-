<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CultureEvent;

$event = CultureEvent::whereNotNull('gallery_uploads')->first();
if ($event) {
    print_r($event->gallery_uploads);
} else {
    echo "No gallery found";
}
