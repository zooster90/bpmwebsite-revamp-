<?php

namespace App\Providers;

use App\Models\Award;
use App\Models\CultureEvent;
use App\Models\News;
use App\Models\PressCoverage;
use App\Models\Project;
use App\Observers\CacheInvalidationObserver;
use App\Observers\ImageCompressionObserver;
use Illuminate\Support\Facades\Gate;
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
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // ── Authorization shortcut ────────────────────────────────────
        // Super Admin role bypasses every Gate / policy check. This is a
        // defensive layer on top of the role checks already baked into
        // each Filament Resource via App\Filament\Concerns\RoleBasedAccess
        // so any future Gate::allows() call also honours the same rule.
        Gate::before(function ($user, string $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        \Filament\Tables\Table::configureUsing(function (\Filament\Tables\Table $table): void {
            $table
                ->paginationPageOptions([10, 25, 50, 100, 'all'])
                ->defaultPaginationPageOption(25)
                ->persistFiltersInSession()
                ->persistSearchInSession()
                ->persistSortInSession();
        });

        Project::observe(ImageCompressionObserver::class);
        Award::observe(ImageCompressionObserver::class);
        CultureEvent::observe(ImageCompressionObserver::class);
        News::observe(ImageCompressionObserver::class);
        PressCoverage::observe(ImageCompressionObserver::class);

        Project::observe(CacheInvalidationObserver::class);
        Award::observe(CacheInvalidationObserver::class);
        CultureEvent::observe(CacheInvalidationObserver::class);
        News::observe(CacheInvalidationObserver::class);
        PressCoverage::observe(CacheInvalidationObserver::class);
    }
}

