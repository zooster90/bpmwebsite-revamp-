<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DiagnosePublicDisk extends Command
{
    protected $signature = 'storage:diagnose-public';

    protected $description = 'Show whether the public disk is currently R2-backed or local, and whether the R2 env vars are visible.';

    public function handle(): int
    {
        $this->info('R2 env vars (presence only, never the value):');
        foreach (['R2_ACCESS_KEY_ID', 'R2_SECRET_ACCESS_KEY', 'R2_BUCKET', 'R2_ENDPOINT', 'IMAGE_CDN_URL'] as $key) {
            $val = env($key);
            $status = $val ? 'SET ('.strlen((string) $val).' chars)' : 'MISSING';
            $this->line("  {$key}: {$status}");
        }

        $this->newLine();
        $this->info('Public disk runtime config:');
        $cfg = config('filesystems.disks.public');
        $this->line("  driver:   ".($cfg['driver'] ?? '?'));
        $this->line("  bucket:   ".($cfg['bucket'] ?? '—'));
        $this->line("  endpoint: ".($cfg['endpoint'] ?? '—'));
        $this->line("  url:      ".($cfg['url'] ?? '—'));
        if (($cfg['driver'] ?? '') === 's3') {
            $this->info('  → R2 IS active for new uploads.');
        } else {
            $this->warn('  → Public disk is LOCAL. R2 not active.');
        }

        $this->newLine();
        $this->info('Live write test (1-byte file, will be cleaned up):');
        $disk = Storage::disk('public');
        $testKey = 'diagnose/'.now()->format('YmdHis').'.txt';
        try {
            $disk->put($testKey, 'r2-test');
            $url = $disk->url($testKey);
            $this->line("  ✓ Wrote {$testKey}");
            $this->line("  url(): {$url}");
            $disk->delete($testKey);
            $this->line("  ✓ Deleted test file");
        } catch (\Throwable $e) {
            $this->error('  ✗ Write failed: '.$e->getMessage());
        }

        return self::SUCCESS;
    }
}
