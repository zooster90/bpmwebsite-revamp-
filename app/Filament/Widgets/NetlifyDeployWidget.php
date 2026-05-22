<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class NetlifyDeployWidget extends Widget
{
    protected string $view = 'filament.widgets.netlify-deploy';

    protected static ?int $sort = 1; // Position it at the top of the dashboard

    protected int|string|array $columnSpan = 'full';

    public ?string $deployStatus = 'idle'; // 'idle', 'running', 'success', 'failed'
    public ?string $deployLog = null;
    public ?string $lastDeployTime = null;

    public function mount()
    {
        $this->lastDeployTime = cache('netlify_last_deploy_time', 'Never');
        
        // Restore deployment status on page load/refresh from log markers
        $logPath = storage_path('logs/netlify_deploy.log');
        $logPath = str_replace('/', DIRECTORY_SEPARATOR, $logPath);
        
        if (file_exists($logPath)) {
            $this->deployLog = file_get_contents($logPath);
            if (str_contains($this->deployLog, '[SUCCESS]')) {
                $this->deployStatus = 'success';
            } elseif (str_contains($this->deployLog, '[FAILED]')) {
                $this->deployStatus = 'failed';
            } elseif (str_contains($this->deployLog, '🚀 [START]')) {
                $this->deployStatus = 'running';
            } else {
                $this->deployStatus = 'idle';
            }
        } else {
            $this->deployStatus = 'idle';
        }
    }

    public function deploy()
    {
        $this->deployStatus = 'running';
        
        $logPath = storage_path('logs/netlify_deploy.log');
        $logPath = str_replace('/', DIRECTORY_SEPARATOR, $logPath);
        
        // Ensure the directory exists
        $logDir = dirname($logPath);
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }

        // Initialize log file
        $initialLog = "🚀 Initializing background deployment pipeline...\n";
        file_put_contents($logPath, $initialLog);
        $this->deployLog = $initialLog;

        // Windows background cmd: start /B cmd /C php artisan deploy:netlify > logPath 2>&1
        $artisanPath = base_path('artisan');
        $artisanPath = str_replace('/', DIRECTORY_SEPARATOR, $artisanPath);
        $command = "start /B cmd /C php \"" . $artisanPath . "\" deploy:netlify > \"" . $logPath . "\" 2>&1";

        pclose(popen($command, "r"));
    }

    public function checkForUpdates()
    {
        if ($this->deployStatus !== 'running') {
            return;
        }

        $logPath = storage_path('logs/netlify_deploy.log');
        $logPath = str_replace('/', DIRECTORY_SEPARATOR, $logPath);

        if (file_exists($logPath)) {
            $this->deployLog = file_get_contents($logPath);

            if (str_contains($this->deployLog, '[SUCCESS]')) {
                $this->deployStatus = 'success';
                $this->lastDeployTime = now()->format('Y-m-d H:i:s');
                cache(['netlify_last_deploy_time' => $this->lastDeployTime]);

                Notification::make()
                    ->title('Deploy Completed!')
                    ->body('Your website has been updated successfully on Netlify.')
                    ->success()
                    ->send();
            } elseif (str_contains($this->deployLog, '[FAILED]')) {
                $this->deployStatus = 'failed';
                Notification::make()
                    ->title('Netlify Deploy Failed')
                    ->body('File upload failed. Check terminal logs in the widget.')
                    ->danger()
                    ->send();
            }
        }
    }
}
