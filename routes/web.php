<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\CultureController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OurPeopleController;
use App\Http\Controllers\CurrentProjectController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Builtech Official Website — Complete Routes
|--------------------------------------------------------------------------
*/

// ── Home & SEO ────────────────────────────────────────────────────────────
Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/sitemap.xml', function () {
    $projects = \App\Models\Project::where('is_published', true)->get();
    $news = \App\Models\News::where('is_published', true)->get();
    
    return response()->view('sitemap', [
        'projects' => $projects,
        'news' => $news
    ])->header('Content-Type', 'text/xml');
});

// ── Robots.txt (tells Google how to crawl) ────────────────────────────
Route::get('/robots.txt', function () {
    $content = implode("\n", [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin/',
        'Disallow: /livewire/',
        '',
        '# Crawl-delay for polite crawling',
        'Crawl-delay: 1',
        '',
        '# Sitemap',
        'Sitemap: ' . url('/sitemap.xml'),
    ]);
    return response($content, 200)->header('Content-Type', 'text/plain');
});

// ── About Us ────────────────────────────────────────────────────────────
Route::get('/about',          fn() => view('story'))->name('about');
Route::get('/story',          fn() => view('story'))->name('story');
Route::get('/our-people',     [OurPeopleController::class, 'index'])->name('our-people');
Route::get('/corporate',      fn() => view('corporate'))->name('corporate');
Route::get('/sustainability', fn() => view('sustainability'))->name('sustainability');

// ── Services & Resources ──
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/links', fn() => view('links'))->name('links');

// ── Projects ────────────────────────────────────────────────────────────
Route::get('/projects',              [ProjectController::class, 'index'])->name('projects.index');
Route::get('/track-records',         [ProjectController::class, 'index'])->name('track-records');
Route::get('/projects/{slug}',       [ProjectController::class, 'show'])->name('projects.show');
Route::get('/ongoing-projects/{slug}', [CurrentProjectController::class, 'show'])->name('ongoing-projects.show');

// ── Media, News & Awards ─────────────────────────────────────────────────
Route::get('/news',    [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/awards',  [AwardController::class, 'index'])->name('awards');
Route::get('/culture', [CultureController::class, 'index'])->name('culture');
Route::get('/media',   [MediaController::class, 'index'])->name('media');

// ── Careers ─────────────────────────────────────────────────────────────
Route::get('/careers', [CareerController::class, 'index'])->name('careers');
Route::post('/careers/apply', [CareerController::class, 'apply'])->name('careers.apply');

// ── Downloads ───────────────────────────────────────────────────────────
Route::get('/downloads', fn() => view('downloads'))->name('downloads');

// ── Legal ───────────────────────────────────────────────────────────────
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy');

// ── Auth ────────────────────────────────────────────────────────────────
Route::get('/login', fn() => view('login'))->name('login');

// ── Contact ─────────────────────────────────────────────────────────────
Route::get('/contact',  fn() => view('contact'))->name('contact');
Route::post('/contact', [InquiryController::class, 'store'])->name('contact.store');

// ── Maintenance ─────────────────────────────────────────────────────────
Route::get('/maintenance', fn() => view('maintenance'))->name('maintenance');

/*
|--------------------------------------------------------------------------
| 🔌 API ROUTES — For Homepage Dynamic Data Loading
|--------------------------------------------------------------------------
| Matches YOUR models exactly:
| - Project (with cover_image media)
| - PressCoverage (with press_image media)
*/
Route::prefix('api')->middleware(['throttle:60,1'])->group(function () {
    
    // Projects API (supports ?flagship=true&limit=10)
    Route::get('/projects', [PageController::class, 'apiProjects']);
    
    // Press Coverage API (renamed to match your model!)
    Route::get('/press-coverage', [PageController::class, 'apiPressCoverage']);
    
    // Stats API
    Route::get('/stats', [PageController::class, 'apiStats']);
});

// ── Legacy Redirects ────────────────────────────────────────────────────
// Note: /track-records is already mapped to ProjectController@index above (line 48)


// ── Analytics Ping — records time-on-page before user leaves ────────────
Route::post('/analytics/ping', function (\Illuminate\Http\Request $r) {
    try {
        \App\Models\PageView::where('session_id', substr(session()->getId() ?? '', 0, 100))
            ->where('url', 'like', '%' . parse_url($r->input('url', ''), PHP_URL_PATH) . '%')
            ->latest()
            ->first()
            ?->update([
                'time_on_page' => (int) min($r->input('seconds', 0), 3600),
                'page_title'   => substr($r->input('title', ''), 0, 300),
            ]);
    } catch (\Throwable) {}
    return response()->json(['ok' => true]);
})->name('analytics.ping');