<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use App\Models\News;
use App\Models\CultureEvent;
use App\Models\Award;
use App\Models\PressCoverage;

$models = [
    'App\Models\Project' => 'cover_image_upload',
    'App\Models\CultureEvent' => 'culture_image_upload',
    'App\Models\News' => 'news_image_upload',
    'App\Models\Award' => 'award_image_upload', // Assuming this is the field or maybe 'logo_upload'
    'App\Models\PressCoverage' => 'press_image_upload',
];

$prefixToRemove = 'http://builtech-app.test/storage/';

foreach ($models as $class => $uploadField) {
    if (!class_exists($class)) continue;
    
    // For Award it might be logo_upload
    if ($class === 'App\Models\Award' && !in_array('award_image_upload', \Illuminate\Support\Facades\Schema::getColumnListing((new $class)->getTable()))) {
        if (in_array('logo_upload', \Illuminate\Support\Facades\Schema::getColumnListing((new $class)->getTable()))) {
            $uploadField = 'logo_upload';
        }
    }
    
    $records = $class::all();
    $count = 0;
    
    foreach ($records as $record) {
        $updated = false;
        
        // Handle image_url to uploadField
        if (!empty($record->image_url)) {
            if (str_starts_with($record->image_url, $prefixToRemove)) {
                $relativePath = str_replace($prefixToRemove, '', $record->image_url);
                $record->{$uploadField} = $relativePath;
                // We keep image_url or clear it depending on preference, let's clear it to fully migrate
                $record->image_url = null;
                $updated = true;
            } elseif (str_contains($record->image_url, 'supabase.co')) {
                // Should have been caught by the other script, but just in case
            }
        }
        
        // Handle gallery_uploads
        if (!empty($record->gallery_uploads) && is_array($record->gallery_uploads)) {
            $newGallery = [];
            foreach ($record->gallery_uploads as $url) {
                if (str_starts_with($url, $prefixToRemove)) {
                    $newGallery[] = str_replace($prefixToRemove, '', $url);
                    $updated = true;
                } else {
                    $newGallery[] = $url;
                }
            }
            if ($updated) {
                $record->gallery_uploads = $newGallery;
            }
        }
        
        if ($updated) {
            $record->disableLogging(); 
            $record->save();
            $count++;
        }
    }
    
    echo "$class: Migrated $count records to local Filament structure.\n";
}
