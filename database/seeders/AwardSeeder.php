<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AwardSeeder extends Seeder
{
    public function run(): void
    {
        $files = [
            'awards.json'                   => ['cat' => null,      'title' => 'title', 'desc' => 'description'],
            'cidb_star_ratings.json'        => ['cat' => 'cidb',    'title' => 'project_name', 'desc' => 'star_rating'],
            'shassic_scores.json'           => ['cat' => 'shassic', 'title' => 'project_name', 'desc' => 'score'],
            'qlassic_conquas_scores.json'   => ['cat' => 'qlassic', 'title' => 'project_name', 'desc' => 'score'],
            'gbi_facilitator_certificates.json' => ['cat' => 'gbi', 'title' => 'title', 'desc' => 'certification_level'],
        ];

        foreach ($files as $fileName => $map) {
            $path = database_path("data/{$fileName}");
            if (!File::exists($path)) continue;

            $json = File::get($path);
            if (str_starts_with($json, "\xef\xbb\xbf")) $json = substr($json, 3);
            
            $data = json_decode($json, true);
            $items = isset($data['value']) ? $data['value'] : $data;

            foreach ($items as $item) {
                $title = $item[$map['title']] ?? 'Untitled Award';
                $year  = $item['year'] ?? $item['completion_year'] ?? 0;
                $cat   = $map['cat'] ?? $item['cat'] ?? $item['category'] ?? 'Other';
                
                // Build a composite description if score exists
                $desc = $item[$map['desc']] ?? '';
                if (isset($item['score'])) $desc = "Score: {$item['score']} | " . $desc;
                if (isset($item['remarks'])) $desc .= " | " . $item['remarks'];

                Award::updateOrCreate(
                    [
                        'name' => $title,
                        'year' => $year,
                        'category' => $cat
                    ],
                    [
                        'description' => trim($desc, ' | '),
                        'issuer'      => $item['issuer'] ?? null,
                        'image_url'   => isset($item['img']) ? (is_array($item['img']) ? ($item['img'][0] ?? null) : $item['img']) : ($item['image_url'] ?? null),
                    ]
                );
            }
        }
    }
}
