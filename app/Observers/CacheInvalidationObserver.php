<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

/**
 * ╔══════════════════════════════════════════════════════╗
 * ║  CacheInvalidationObserver                           ║
 * ║  ─────────────────────────────────────────────────   ║
 * ║  Auto-clears ALL frontend caches the moment any     ║
 * ║  record is created, updated, or deleted in admin.   ║
 * ║  This ensures 100% real-time frontend updates.      ║
 * ╚══════════════════════════════════════════════════════╝
 */
class CacheInvalidationObserver
{
    /**
     * All known frontend cache keys used across controllers.
     */
    protected array $keys = [
        // HomeController (PageController)
        'homepage.flagship_projects',
        'homepage.latest_projects_fallback',
        'homepage.press_coverage',
        // Any other keys you may add in future
        'homepage.awards',
        'homepage.news',
        'homepage.culture',
        'homepage.stats',
        'homepage.people',
        'homepage.services',
    ];

    public function created($model): void
    {
        $this->flush();
    }

    public function updated($model): void
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

    /**
     * Flush all known frontend caches instantly.
     */
    protected function flush(): void
    {
        foreach ($this->keys as $key) {
            Cache::forget($key);
        }
    }
}
