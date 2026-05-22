<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/news.json'));
        
        // Strip BOM if present
        if (str_starts_with($json, "\xef\xbb\xbf")) {
            $json = substr($json, 3);
        }
        
        $data = json_decode($json, true);
        $newsItems = isset($data['value']) ? $data['value'] : $data;

        foreach ($newsItems as $item) {
            $mainImage = !empty($item['img']) && count($item['img']) > 0 ? $item['img'][0] : null;
            
            News::updateOrCreate(
                ['slug' => Str::slug($item['title'] ?? 'untitled-news-' . uniqid())],
                [
                    'title' => $item['title'] ?? 'Untitled News',
                    'category' => $item['type'] ?? $item['category'] ?? 'General',
                    'excerpt' => $item['description'] ?? '',
                    'content' => $item['content'] ?? '',
                    'image_url' => $mainImage,
                    'gallery_uploads' => !empty($item['img']) ? $item['img'] : [],
                    'is_featured' => false,
                    'published_date' => isset($item['date']) ? Carbon::createFromFormat('d/m/Y', $item['date'])->format('Y-m-d') : (isset($item['created_at']) ? substr($item['created_at'], 0, 10) : Carbon::now()),
                ]
            );
        }
    }
}
