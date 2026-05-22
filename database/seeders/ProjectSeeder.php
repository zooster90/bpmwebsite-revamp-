<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/projects.json'));
        
        // Strip BOM if present
        if (str_starts_with($json, "\xef\xbb\xbf")) {
            $json = substr($json, 3);
        }
        
        $data = json_decode($json, true);
        $projects = isset($data['value']) ? $data['value'] : $data;

        foreach ($projects as $item) {
            $coverImage = !empty($item['img']) && count($item['img']) > 0 ? $item['img'][0] : null;
            
            Project::updateOrCreate(
                ['slug' => Str::slug($item['title'] ?? 'untitled-project-' . uniqid())],
                [
                    'name' => $item['title'] ?? 'Untitled Project',
                    'category' => $item['cat'] ?? 'General',
                    'client' => null,
                    'location' => $item['loc'] ?? null,
                    'status' => $item['status'] ?? 'Completed',
                    'year' => $item['year'] ?? null,
                    'description' => $item['description'] ?? '',
                    'image_url' => $coverImage,
                    'gallery_uploads' => !empty($item['img']) ? $item['img'] : [],
                    'award' => $item['award'] ?? null,
                    'is_published' => true,
                ]
            );
        }
    }
}
