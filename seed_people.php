<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$teams = [
    ['DSCF7225.jpg', 'Head Office Team',        'Corporate HQ, Penang'],
    ['MSF.jpg',      'MSF Project Team',         'Industrial Project'],
    ['WCL.jpg',      'WCL Project Team',         'Civil Works'],
    ['WCLB.jpg',     'WCLB Project Team',        'Civil Works'],
    ['TCF.jpg',      'TCF Project Team',         'Site Operations'],
    ['TM.jpg',       'TM Project Team',          'Site Operations'],
    ['HYP (1)(1).jpg','HYP Project Team',        'Industrial Project'],
    ['klm.jpg',      'Site Construction Crew',   'Field Operations'],
];

foreach($teams as $i => $t) {
    App\Models\OurPeople::updateOrCreate(
        ['title' => $t[1]],
        ['image' => 'img/images/'.$t[0], 'department' => $t[2], 'sort_order' => $i * 10]
    );
}
echo "Done\n";
