<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Award;
echo 'Before fix, untitled: '.Award::where('name', 'Untitled Award')->count().PHP_EOL;
$items = Award::where('name', 'Untitled Award')->get();
foreach($items as $i) {
    $c = strtoupper($i->category ?? '');
    $i->name = ($c ? $c.' Certification '.$i->year : 'Builtech Excellence Award '.$i->year);
    $i->save();
}
echo 'After fix, untitled: '.Award::where('name', 'Untitled Award')->count().PHP_EOL;

$hasImg = Award::whereNotNull('image_url')->count();
echo 'Has image_url: '.$hasImg.PHP_EOL;

// Fallback logic for image_url if logo_upload is empty
$map = [
    'cidb'     => 'images/cidb_logo-768x250.png',
    'shassic'  => 'images/shassic_logo-removebg-preview.png',
    'gbi'      => 'images/GBI logo ..png',
    'qlassic'  => 'images/R (1).png',
    'iso'      => 'images/ISO_14001_Latest.jpg',
    'quality'  => 'images/SGS_ISO 9001 - DSM Mark_TCL_LR.jpg',
    'safety'   => 'images/MSOSH Logo.jpg',
    'business' => 'images/SME .png',
];

$all = Award::whereNull('logo_upload')->whereNull('image_url')->get();
$count=0;
foreach($all as $a) {
    if(isset($map[strtolower(trim($a->category))])) {
        $a->image_url = '/' . $map[strtolower(trim($a->category))];
        $a->save();
        $count++;
    }
}
echo 'Fixed image URLs: '.$count.PHP_EOL;
