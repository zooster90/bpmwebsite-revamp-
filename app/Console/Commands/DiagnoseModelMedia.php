<?php

namespace App\Console\Commands;

use App\Models\CurrentProject;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DiagnoseModelMedia extends Command
{
    protected $signature = 'images:diagnose
        {model : project | current-project}
        {id : The model id (e.g. 1)}';

    protected $description = 'Print every media row for the given model + check whether the file exists on disk and via URL';

    public function handle(): int
    {
        $map = [
            'project'         => Project::class,
            'current-project' => CurrentProject::class,
        ];

        $arg = $this->argument('model');
        if (! isset($map[$arg])) {
            $this->error("Unknown model '{$arg}'. Use: project, current-project");
            return self::INVALID;
        }

        $model = $map[$arg]::find($this->argument('id'));
        if (! $model) {
            $this->error("No {$arg} with id={$this->argument('id')}");
            return self::INVALID;
        }

        $this->info(get_class($model)." #{$model->getKey()}");
        $this->line("  cover_image_upload / image_upload column: ".($model->cover_image_upload ?? $model->image_upload ?? '(null)'));
        $this->line("  image_url column: ".($model->image_url ?? '(null)'));
        $this->newLine();

        $media = $model->media()->orderBy('collection_name')->get();
        if ($media->isEmpty()) {
            $this->warn('No media rows attached to this model.');
            return self::SUCCESS;
        }

        foreach ($media as $m) {
            $this->info("--- Media #{$m->id} ---");
            $this->line("  collection_name: {$m->collection_name}");
            $this->line("  disk:            {$m->disk}");
            $this->line("  file_name:       {$m->file_name}");
            $this->line("  mime_type:       {$m->mime_type}");
            $this->line("  size:            {$m->size} bytes");

            $path = $m->getPath();
            $this->line("  full local path: {$path}");
            $this->line("  file_exists():   ".(is_file($path) ? 'YES' : 'NO'));

            try {
                $diskExists = Storage::disk($m->disk)->exists($m->getPathRelativeToRoot());
                $this->line("  Storage::disk('{$m->disk}')->exists(): ".($diskExists ? 'YES' : 'NO'));
            } catch (\Throwable $e) {
                $this->line("  Storage disk check error: ".$e->getMessage());
            }

            try {
                $url = $m->getUrl();
                $this->line("  getUrl():        {$url}");
            } catch (\Throwable $e) {
                $this->line("  getUrl() error:  ".$e->getMessage());
            }

            if (function_exists('cdn_rewrite')) {
                try {
                    $rewritten = cdn_rewrite($m->getUrl());
                    $this->line("  cdn_rewrite():   {$rewritten}");
                } catch (\Throwable $e) {
                    $this->line("  cdn_rewrite() error: ".$e->getMessage());
                }
            }

            $this->newLine();
        }

        return self::SUCCESS;
    }
}
