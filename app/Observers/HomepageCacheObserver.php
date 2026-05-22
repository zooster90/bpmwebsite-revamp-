<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class HomepageCacheObserver
{
    private const HOMEPAGE_KEYS = [
        'homepage.flagship_projects',
        'homepage.latest_projects_fallback',
        'homepage.press_coverage',
    ];

    public function saved($model): void
    {
        $this->flush();
    }

    public function deleted($model): void
    {
        $this->flush();
    }

    public function restored($model): void
    {
        $this->flush();
    }

    private function flush(): void
    {
        foreach (self::HOMEPAGE_KEYS as $key) {
            Cache::forget($key);
        }
    }
}
