<?php
/**
 * SUPABASE DATA FETCHER
 * This script connects to the live Supabase API and pulls all data into the local Laravel DB.
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use App\Models\Project;
use App\Models\Award;
use App\Models\News;
use App\Models\CultureEvent;
use App\Models\PressCoverage;
use App\Models\JobOpening;
use App\Models\CurrentProject;
use Illuminate\Support\Str;

// Configuration from cms.js
$SUPABASE_URL = 'https://guvifomiadxehmtrqrfu.supabase.co';
$SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imd1dmlmb21pYWR4ZWhtdHJxcmZ1Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzMxMDc1MjUsImV4cCI6MjA4ODY4MzUyNX0.8gy3oPTSwPXCZHAi0FbmpjkIrHQuZmWd_TE-h-L0gD8';

$tables = [
    'projects'         => Project::class,
    'awards'           => Award::class,
    'news'             => News::class,
    'culture'          => CultureEvent::class,
    'press_coverage'   => PressCoverage::class,
    'job_openings'     => JobOpening::class,
    'current_projects' => CurrentProject::class,
];

echo "🚀 Starting Supabase Data Migration...\n";

foreach ($tables as $supabaseTable => $modelClass) {
    echo "📦 Fetching table: $supabaseTable...\n";
    
    $response = Http::withHeaders([
        'apikey' => $SUPABASE_KEY,
        'Authorization' => 'Bearer ' . $SUPABASE_KEY
    ])->get("$SUPABASE_URL/rest/v1/$supabaseTable?select=*");

    if ($response->failed()) {
        echo "❌ Failed to fetch $supabaseTable: " . $response->body() . "\n";
        continue;
    }

    $data = $response->json();
    $count = 0;

    foreach ($data as $item) {
        // Sanitize and Map
        $payload = $item;
        
        // Handle common mapping issues found in cms.js
        if (isset($payload['cat']) && !isset($payload['category'])) $payload['category'] = $payload['cat'];
        if (isset($payload['loc']) && !isset($payload['location'])) $payload['location'] = $payload['loc'];
        if (isset($payload['publish_date']) && !isset($payload['date'])) $payload['date'] = $payload['publish_date'];
        
        // Handle Title -> Name mapping (Crucial for historical projects)
        if ($supabaseTable === 'projects' && isset($payload['title']) && !isset($payload['name'])) {
            $payload['name'] = $payload['title'];
        }
        // Handle Progress for Current Projects
        if ($supabaseTable === 'current_projects' && isset($payload['progress'])) {
            $payload['completion_percentage'] = (int)str_replace('%', '', $payload['progress']);
        }
        
        // Ensure slug for projects, news, and current projects if missing
        if (in_array($supabaseTable, ['projects', 'news', 'current_projects']) && empty($payload['slug'])) {
            $base = $payload['name'] ?? ($payload['title'] ?? ($payload['headline'] ?? 'item'));
            $payload['slug'] = Str::slug($base) . '-' . rand(100, 999);
        }

        // Handle images (photos -> gallery_uploads)
        if (isset($payload['photos']) && is_array($payload['photos'])) {
            $payload['gallery_uploads'] = $payload['photos'];
        }

        // Upsert by ID if exists, or name
        try {
            $modelClass::updateOrCreate(
                ['id' => $payload['id'] ?? null],
                $payload
            );
            $count++;
        } catch (\Exception $e) {
            echo "⚠️ Error inserting record in $supabaseTable: " . $e->getMessage() . "\n";
            // Try without ID
            unset($payload['id']);
            try {
                $modelClass::create($payload);
                $count++;
            } catch (\Exception $e2) {
                echo "❌ Hard failure for record in $supabaseTable: " . $e2->getMessage() . "\n";
            }
        }
    }

    echo "✅ Successfully migrated $count records for $supabaseTable.\n";
}

echo "\n✨ Data migration complete! Run 'php migrate_supabase.php' next to download images locally.\n";
