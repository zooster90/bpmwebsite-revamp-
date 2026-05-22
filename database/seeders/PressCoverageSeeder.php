<?php

namespace Database\Seeders;

use App\Models\PressCoverage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PressCoverageSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/media.json'));
        
        // Strip BOM if present
        if (str_starts_with($json, "\xef\xbb\xbf")) {
            $json = substr($json, 3);
        }
        
        $data = json_decode($json, true);

        $press = isset($data['value']) ? $data['value'] : $data;

        foreach ($press as $item) {
            PressCoverage::updateOrCreate(
                ['headline' => $item['headline'] ?? $item['title'] ?? 'Untitled Clipping'],
                [
                    'publication'    => $item['publication'] ?? $item['media_source'] ?? $item['source'] ?? 'Unknown',
                    'published_date' => $item['date'] ?? $item['publish_date'] ?? now()->toDateString(),
                    'external_url'   => $item['external_url'] ?? $item['link'] ?? $item['url'] ?? null,
                    'excerpt'        => $item['excerpt'] ?? $item['summary'] ?? $item['desc'] ?? '',
                    'image_url'      => isset($item['img']) ? (is_array($item['img']) ? ($item['img'][0] ?? null) : $item['img']) : ($item['image_url'] ?? $item['clipping_url'] ?? null),
                ]
            );
        }
    }
}
