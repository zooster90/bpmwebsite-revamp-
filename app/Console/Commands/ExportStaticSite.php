<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExportStaticSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:static';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the full Laravel frontend statically for Netlify';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting premium static site compilation for Builtech...');

        $distDir = base_path('dist');

        // 1. Clean the output directory
        if (File::exists($distDir)) {
            File::cleanDirectory($distDir);
        } else {
            File::makeDirectory($distDir, 0755, true, true);
        }

        // 2. Define static routes to export
        $urls = [
            '/' => 'index.html',
            '/about' => 'about/index.html',
            '/story' => 'story/index.html',
            '/our-people' => 'our-people/index.html',
            '/corporate' => 'corporate/index.html',
            '/sustainability' => 'sustainability/index.html',
            '/services' => 'services/index.html',
            '/links' => 'links/index.html',
            '/projects' => 'projects/index.html',
            '/track-records' => 'track-records/index.html',
            '/news' => 'news/index.html',
            '/awards' => 'awards/index.html',
            '/culture' => 'culture/index.html',
            '/media' => 'media/index.html',
            '/careers' => 'careers/index.html',
            '/downloads' => 'downloads/index.html',
            '/privacy-policy' => 'privacy-policy/index.html',
            '/login' => 'login/index.html',
            '/contact' => 'contact/index.html',
            '/maintenance' => 'maintenance/index.html',
            '/sitemap.xml' => 'sitemap.xml',
        ];

        // Add dynamic projects
        try {
            foreach (\App\Models\Project::where('is_published', true)->get() as $p) {
                $urls['/projects/' . $p->slug] = 'projects/' . $p->slug . '/index.html';
            }
        } catch (\Throwable $e) {
            $this->warn('Could not load Project model entries: ' . $e->getMessage());
        }

        // Add dynamic services
        try {
            foreach (\App\Models\Service::where('is_active', true)->get() as $s) {
                $urls['/services/' . $s->slug] = 'services/' . $s->slug . '/index.html';
            }
        } catch (\Throwable $e) {
            $this->warn('Could not load Service model entries: ' . $e->getMessage());
        }

        // Add dynamic news articles
        try {
            foreach (\App\Models\News::where('is_published', true)->get() as $n) {
                $urls['/news/' . $n->slug] = 'news/' . $n->slug . '/index.html';
            }
        } catch (\Throwable $e) {
            $this->warn('Could not load News model entries: ' . $e->getMessage());
        }

        // Add dynamic ongoing projects
        try {
            foreach (\App\Models\CurrentProject::where('is_active', true)->get() as $op) {
                $urls['/ongoing-projects/' . $op->slug] = 'ongoing-projects/' . $op->slug . '/index.html';
            }
        } catch (\Throwable $e) {
            $this->warn('Could not load CurrentProject model entries: ' . $e->getMessage());
        }

        // 3. Request each URL internally and save the HTML
        foreach ($urls as $url => $outputPath) {
            $this->line("Compiling static page: {$url} -> {$outputPath}");

            $request = Request::create($url, 'GET');
            $request->headers->set('HOST', 'builtech-app.test');
            $request->setLaravelSession(app('session')->driver());

            try {
                $response = app()->handle($request);
                $html = $response->getContent();

                // Clean the generated links to point properly in static environment:
                $html = str_replace([
                    'http://builtech-app.test',
                    'https://builtech-app.test',
                ], '', $html);

                // Create the directories
                $fullOutputPath = $distDir . '/' . $outputPath;
                $dir = dirname($fullOutputPath);
                if (!File::isDirectory($dir)) {
                    File::makeDirectory($dir, 0755, true, true);
                }

                File::put($fullOutputPath, $html);
            } catch (\Throwable $e) {
                $this->error("Failed to compile page [{$url}]: " . $e->getMessage());
            }
        }

        // 4. Copy the public assets directory to dist
        $this->info('Copying public asset directories into the static distribution...');
        $publicDir = public_path();
        
        $files = File::allFiles($publicDir);
        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            
            // Exclude dynamic PHP files and server configuration files
            if (in_array($relativePath, ['index.php', '.htaccess', 'web.config', 'robots.txt'])) {
                continue;
            }
            
            $realPath = $file->getRealPath();
            
            // Defensive checks: skip links and directories
            if (is_dir($realPath) || is_link($realPath)) {
                continue;
            }
            
            $targetPath = $distDir . '/' . $relativePath;
            $dir = dirname($targetPath);
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true, true);
            }
            
            try {
                File::copy($realPath, $targetPath);
            } catch (\Throwable $e) {
                $this->warn("Skipped copy for {$relativePath}: " . $e->getMessage());
            }
        }

        // Explicitly copy the storage/app/public directory to dist/storage
        // This is required because File::allFiles skips symbolic links!
        $this->info('Copying uploaded storage media...');
        $storageDir = storage_path('app/public');
        if (File::exists($storageDir)) {
            File::copyDirectory($storageDir, $distDir . '/storage');
        }

        // Write a robots.txt specifically for static deployment SEO
        $robotsContent = "User-agent: *\nAllow: /\nSitemap: /sitemap.xml\n";
        File::put($distDir . '/robots.txt', $robotsContent);

        $this->info('Static site successfully compiled into /dist directory!');
    }
}
