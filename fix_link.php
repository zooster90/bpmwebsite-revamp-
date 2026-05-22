<?php
$publicStorage = __DIR__ . '/public/storage';
$appStorage = __DIR__ . '/storage/app/public';

if (file_exists($publicStorage)) {
    echo "Removing existing storage link/directory...\n";
    if (is_link($publicStorage) || is_file($publicStorage)) {
        unlink($publicStorage);
    } else {
        // It's a directory, might be a junction
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            exec("rmdir \"$publicStorage\"");
        } else {
            rmdir($publicStorage);
        }
    }
}

echo "Creating storage link...\n";
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $command = "mklink /J \"$publicStorage\" \"$appStorage\"";
    exec($command, $output, $return);
    echo implode("\n", $output) . "\n";
    echo "Return code: $return\n";
} else {
    symlink($appStorage, $publicStorage);
}

echo "Done.\n";
