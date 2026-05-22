<?php

namespace Database\Seeders;

use App\Models\CultureEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CultureEventSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/culture.json'));
        
        // Strip BOM if present
        if (str_starts_with($json, "\xef\xbb\xbf")) {
            $json = substr($json, 3);
        }
        
        $data = json_decode($json, true);

        $events = isset($data['value']) ? $data['value'] : $data;

        foreach ($events as $item) {
            $type = $item['type'] ?? $item['cat'] ?? $item['category'] ?? 'work';
            
            // Map legacy types to current categories
            $categoryMap = [
                'tb'          => 'team_building',
                'team'        => 'team_building',
                'intern'      => 'internship',
                'csr'         => 'csr',
                'festive'     => 'festive',
                'trip'        => 'trip',
                'work'        => 'work',
                'awards'      => 'awards',
                'sports'      => 'sports',
                'anniversary' => 'anniversary',
                'family'      => 'family_day',
                'safety'      => 'safety'
            ];
            
            $category = $categoryMap[strtolower($type)] ?? $type;

            // Handle images
            $images = isset($item['img']) ? (is_array($item['img']) ? $item['img'] : [$item['img']]) : [];
            $mainImage = $images[0] ?? $item['image_url'] ?? null;
            
            CultureEvent::updateOrCreate(
                ['slug' => Str::slug(($item['title'] ?? $item['name'] ?? 'event') . '-' . ($item['id'] ?? uniqid()))],
                [
                    'title'           => $item['title'] ?? $item['name'] ?? 'Untitled Event',
                    'name'            => $item['name'] ?? null,
                    'event_date'      => isset($item['date']) ? $item['date'] : (isset($item['created_at']) ? substr($item['created_at'], 0, 10) : now()->toDateString()),
                    'year'            => $item['year'] ?? (isset($item['date']) ? substr($item['date'], 0, 4) : date('Y')),
                    'category'        => $category,
                    'description'     => $item['desc'] ?? $item['description'] ?? '',
                    'image_url'       => $mainImage,
                    'gallery_uploads' => $images, // Store all URLs for now
                ]
            );
        }
    }
}
