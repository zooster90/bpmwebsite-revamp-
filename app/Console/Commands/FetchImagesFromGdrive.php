<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

class FetchImagesFromGdrive extends Command
{
    protected $signature = 'images:fetch-from-gdrive
                            {file_id : Google Drive file ID (the part between /d/ and /view in the share URL)}
                            {--target=public : where to extract: public (default) or storage}
                            {--keep-zip : do not delete the downloaded zip after extraction}';

    protected $description = 'Download a public Google Drive zip of site images and extract it into the app filesystem.';

    public function handle(): int
    {
        $fileId = $this->argument('file_id');
        $target = $this->option('target') === 'storage'
            ? storage_path('app/public')
            : public_path();

        if (! is_dir($target)) {
            mkdir($target, 0775, true);
        }

        $zipPath = storage_path('app/gdrive-images-' . substr($fileId, 0, 8) . '.zip');

        $this->info("Fetching from Google Drive: {$fileId}");
        $this->line("Saving to: {$zipPath}");

        if (! $this->download($fileId, $zipPath)) {
            return self::FAILURE;
        }

        $sizeMb = filesize($zipPath) / 1024 / 1024;
        $this->info(sprintf('Downloaded: %.1f MB', $sizeMb));

        if (! $this->isZip($zipPath)) {
            $head = substr(file_get_contents($zipPath, false, null, 0, 500), 0, 500);
            $this->error('Downloaded file is NOT a zip. First bytes:');
            $this->line($head);
            $this->error('Likely: file is private, or GDrive returned an HTML warning page.');
            $this->error('Fix: in Google Drive, right-click the file → Share → "Anyone with the link → Viewer".');
            return self::FAILURE;
        }

        $this->info("Extracting into: {$target}");
        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            $this->error('Could not open zip archive.');
            return self::FAILURE;
        }
        $entries = $zip->numFiles;
        $zip->extractTo($target);
        $zip->close();

        if (! $this->option('keep-zip')) {
            @unlink($zipPath);
        }

        $this->info("Extracted {$entries} entries.");
        $this->info('Done. Reload your site — images should now load.');
        return self::SUCCESS;
    }

    /**
     * Download a public GDrive file, bypassing the large-file confirmation page.
     */
    private function download(string $fileId, string $destPath): bool
    {
        $endpoints = [
            // newer host that respects ?confirm=t without scraping HTML
            "https://drive.usercontent.google.com/download?id={$fileId}&export=download&confirm=t",
            // legacy fallback
            "https://drive.google.com/uc?export=download&id={$fileId}&confirm=t",
        ];

        foreach ($endpoints as $url) {
            $this->line("  → trying: " . parse_url($url, PHP_URL_HOST));

            $fp = fopen($destPath, 'w');
            if ($fp === false) {
                $this->error("Cannot open {$destPath} for writing.");
                return false;
            }

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_FILE           => $fp,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; LaravelImageFetcher/1.0)',
                CURLOPT_TIMEOUT        => 1800,           // 30 min hard cap
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_NOPROGRESS     => false,
                CURLOPT_PROGRESSFUNCTION => function ($ch, $expected, $downloaded) {
                    static $last = 0;
                    if ($expected <= 0) return 0;
                    $pct = (int) (($downloaded / $expected) * 100);
                    if ($pct !== $last && $pct % 10 === 0) {
                        $last = $pct;
                        echo "    {$pct}% (" . round($downloaded / 1024 / 1024, 1) . " / " . round($expected / 1024 / 1024, 1) . " MB)\n";
                    }
                    return 0;
                },
            ]);

            $ok    = curl_exec($ch);
            $code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            fclose($fp);

            if ($ok && $code === 200 && filesize($destPath) > 1024) {
                return true;
            }

            $this->warn("    HTTP {$code} {$error}");
        }

        $this->error('All Google Drive endpoints failed.');
        return false;
    }

    private function isZip(string $path): bool
    {
        if (filesize($path) < 4) return false;
        $fp = fopen($path, 'rb');
        $sig = fread($fp, 4);
        fclose($fp);
        // ZIP files start with 'PK\x03\x04'
        return $sig === "PK\x03\x04";
    }
}
