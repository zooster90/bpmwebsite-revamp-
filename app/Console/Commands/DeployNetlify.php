<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeployNetlify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:netlify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform static site export and push the output to Netlify CDN in the background';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🚀 [START] Netlify Deployment Pipeline");
        $this->info("--------------------------------------------------");
        $this->info("📦 Step 1: Compiling Static Pages...");
        $this->info("--------------------------------------------------");

        try {
            // Run the export:static artisan command
            $this->call('export:static');
            $this->info("\n✔ Static compilation completed successfully!");
            $this->info("✔ Static site fully compiled into /dist directory.\n");
        } catch (\Throwable $e) {
            $this->error("\n❌ Static compilation failed: " . $e->getMessage());
            $this->error("\n❌ [FAILED] Deployment aborted.");
            return 1;
        }

        $this->info("--------------------------------------------------");
        $this->info("🚀 Step 2: Uploading static files to Netlify...");
        $this->info("--------------------------------------------------");

        try {
            $basePath = base_path();
            
            // Disable Netlify telemetry prompts by setting environment variables
            putenv("NETLIFY_TELEMETRY_DISABLE=1");
            $_ENV['NETLIFY_TELEMETRY_DISABLE'] = '1';
            
            // Run the deployment command with -y flag to avoid interactive npx prompts
            // Added --no-build so Netlify CLI doesn't try to run vite build, which fails in PHP popen context.
            $command = "cd \"{$basePath}\" && npx -y netlify deploy --prod --dir=dist --no-build 2>&1";
            
            $process = popen($command, 'r');
            if (is_resource($process)) {
                while (!feof($process)) {
                    $line = fgets($process);
                    if ($line !== false) {
                        $this->output->write($line);
                    }
                }
                $returnCode = pclose($process);
                
                if ($returnCode === 0) {
                    $this->info("\n🎉 [SUCCESS] Deployment completed successfully!");
                    return 0;
                } else {
                    $this->error("\n❌ [FAILED] Netlify upload failed with exit code {$returnCode}");
                    return $returnCode;
                }
            } else {
                $this->error("❌ Could not start Netlify deploy process.");
                $this->error("\n❌ [FAILED] Deployment aborted.");
                return 1;
            }
        } catch (\Throwable $e) {
            $this->error("\n❌ Error running Netlify deploy: " . $e->getMessage());
            $this->error("\n❌ [FAILED] Deployment aborted.");
            return 1;
        }
    }
}
