<?php
$files = [
    'news'     => 'database/data/news.json',
    'projects' => 'database/data/projects.json',
    'culture'  => 'database/data/culture.json',
    'awards'   => 'database/data/awards.json',
    'media'    => 'database/data/media.json',
];

$allImages = [];

foreach ($files as $table => $file) {
    $raw = file_get_contents($file);
    $data = json_decode($raw, true);
    
    // Find the records array — could be 'value', root array, etc.
    $items = [];
    if (isset($data['value'])) {
        $items = $data['value'];
    } elseif (is_array($data) && isset($data[0])) {
        $items = $data;
    }
    
    $images = [];
    foreach ($items as $item) {
        $imgField = $item['img'] ?? [];
        if (is_string($imgField)) {
            $imgField = json_decode($imgField, true) ?? [$imgField];
        }
        if (is_array($imgField)) {
            foreach ($imgField as $url) {
                if (is_string($url) && str_contains($url, 'supabase')) {
                    $images[] = $url;
                    $allImages[] = ['table' => $table, 'url' => $url];
                }
            }
        }
    }
    
    echo "$table: " . count($items) . " records, " . count($images) . " Supabase images\n";
    if (!empty($images)) {
        echo "  Sample: " . $images[0] . "\n";
    }
}

echo "\n=== TOTAL Supabase images to download: " . count($allImages) . " ===\n";

// Also check the raw content for any supabase URLs we may have missed
foreach ($files as $table => $file) {
    $raw = file_get_contents($file);
    preg_match_all('/https:\/\/[a-z]+\.supabase\.co\/storage\/v1\/object\/public\/[^\s"]+/i', $raw, $matches);
    if (!empty($matches[0])) {
        $unique = array_unique($matches[0]);
        echo "\n$table has " . count($unique) . " unique Supabase URLs via regex:\n";
        foreach (array_slice($unique, 0, 3) as $url) {
            echo "  $url\n";
        }
    }
}
