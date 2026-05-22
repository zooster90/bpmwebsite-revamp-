<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

echo "APP_URL: " . config('app.url') . "\n";
echo "Filesystem Default: " . config('filesystems.default') . "\n";
echo "Public Disk URL: " . config('filesystems.disks.public.url') . "\n";

$project = Project::first();
if ($project) {
    echo "Project: " . $project->name . "\n";
    $media = $project->getFirstMedia('gallery');
    if ($media) {
        echo "Media ID: " . $media->id . "\n";
        echo "Media Disk: " . $media->disk . "\n";
        echo "Media URL: " . $media->getUrl() . "\n";
        echo "Media Full Path: " . $media->getPath() . "\n";
        echo "File Exists: " . (file_exists($media->getPath()) ? 'YES' : 'NO') . "\n";
    } else {
        echo "No media found in 'gallery' collection for this project.\n";
    }
} else {
    echo "No projects found.\n";
}
