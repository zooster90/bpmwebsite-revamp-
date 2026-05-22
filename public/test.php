<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$cats = \App\Models\Project::distinct()->pluck('category')->toArray();
file_put_contents(__DIR__ . '/test-output.txt', json_encode($cats));
echo "Done";
