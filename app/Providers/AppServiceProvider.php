<?php

namespace App\Providers;

use App\Models\Award;
use App\Models\CultureEvent;
use App\Models\News;
use App\Models\PressCoverage;
use App\Models\Project;
use App\Observers\HomepageCacheObserver;
use App\Observers\ImageCompressionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the ImageCompressionService as a singleton for efficiency
        $this->app->singleton(\App\Services\ImageCompressionService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * Auto-compresses uploaded images to WebP (HD quality, smaller file size)
     * on every create/update for all content models with image upload fields.
     */
    public function boot(): void
    {
        // Force HTTPS if running behind Expose or any reverse proxy to fix mixed content
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Project::observe(ImageCompressionObserver::class);
        Award::observe(ImageCompressionObserver::class);
        CultureEvent::observe(ImageCompressionObserver::class);
        News::observe(ImageCompressionObserver::class);
        PressCoverage::observe(ImageCompressionObserver::class);

        Project::observe(HomepageCacheObserver::class);
        PressCoverage::observe(HomepageCacheObserver::class);
    }
}

