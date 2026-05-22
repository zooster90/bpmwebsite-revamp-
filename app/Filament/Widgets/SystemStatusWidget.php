<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class SystemStatusWidget extends Widget
{
    protected static ?int $sort = 6;

    protected string $view = 'filament.widgets.system-status';

    public function getViewData(): array
    {
        $dbName = config('database.default');
        $dbDriver = config("database.connections.{$dbName}.driver");
        
        $dbSize = 'Unknown';
        try {
            if ($dbDriver === 'sqlite') {
                $path = config("database.connections.{$dbName}.database");
                if (file_exists($path)) {
                    $size = filesize($path);
                    $dbSize = round($size / 1024 / 1024, 2) . ' MB';
                }
            } elseif ($dbDriver === 'mysql') {
                $query = DB::select('SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = ?', [config("database.connections.{$dbName}.database")]);
                $dbSize = round($query[0]->size, 2) . ' MB';
            }
        } catch (\Exception $e) {
            $dbSize = 'N/A';
        }

        return [
            'phpVersion' => PHP_VERSION,
            'laravelVersion' => App::version(),
            'environment' => App::environment(),
            'dbDriver' => $dbDriver,
            'dbSize' => $dbSize,
            'serverSoftware' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
        ];
    }
}
