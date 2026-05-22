<?php
function searchDir($dir, $pattern) {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($it as $file) {
        if ($file->isDir()) continue;
        if (pathinfo($file->getPathname(), PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($file->getPathname());
            if (strpos($content, $pattern) !== false) {
                // Find matching lines
                $lines = explode("\n", $content);
                foreach ($lines as $i => $line) {
                    if (strpos($line, $pattern) !== false) {
                        echo "File: " . $file->getPathname() . " (Line " . ($i + 1) . "): " . trim($line) . "\n";
                    }
                }
            }
        }
    }
}

echo "=== SEARCH FOR ->category ===\n";
searchDir('app', '->category');
searchDir('resources/views', '->category');

echo "=== SEARCH FOR ['category'] ===\n";
searchDir('app', "['category']");
searchDir('resources/views', "['category']");
