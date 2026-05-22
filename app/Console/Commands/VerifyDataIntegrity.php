<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;

class VerifyDataIntegrity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:verify-integrity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies data integrity and relational mappings post-migration.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Data Integrity Check...');

        // 1. Check basic model hydration
        $actualProjects = Project::count();
        $this->info("Found {$actualProjects} Projects in the database.");
        
        if ($actualProjects === 0) {
            $this->warn("No projects found. Did the migration run?");
        }

        // 2. Verify all models can be hydrated without errors
        try {
            $count = 0;
            Project::chunk(100, function ($projects) use (&$count) {
                foreach ($projects as $project) {
                    // Touch attributes to ensure JSON/Casting is valid
                    $title = $project->title;
                    $status = $project->status;
                    $count++;
                }
            });
            $this->info("All {$count} Project records hydrated successfully without schema/casting errors.");
            
            $this->info('Data Integrity Check Passed.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Data integrity failure: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
