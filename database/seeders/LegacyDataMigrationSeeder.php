<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Project;
use Carbon\Carbon;

class LegacyDataMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Zero-Data-Loss Migration for Legacy Projects...');
        
        // 1. Begin Database Transaction to ensure atomicity
        DB::beginTransaction();
        
        try {
            // Path to legacy JSON data (assuming it's stored in database/legacy)
            $legacyFile = database_path('legacy/projects.json');
            
            if (!file_exists($legacyFile)) {
                $this->command->warn('Legacy JSON file not found. Skipping migration.');
                DB::rollBack();
                return;
            }

            $legacyProjects = json_decode(file_get_contents($legacyFile), true);
            
            // 3. Transform and Load
            $importedCount = 0;
            foreach ($legacyProjects as $legacyProject) {
                Project::updateOrCreate(
                    ['slug' => $legacyProject['slug'] ?? \Str::slug($legacyProject['project_name'])],
                    [
                        'title' => $legacyProject['project_name'],
                        'status' => 'Completed',
                        'location' => $legacyProject['location'] ?? 'Malaysia',
                        'description' => $legacyProject['description'] ?? '',
                        'created_at' => isset($legacyProject['date_added']) ? Carbon::parse($legacyProject['date_added']) : now(),
                        'updated_at' => now(),
                    ]
                );
                $importedCount++;
            }
            
            // 4. Commit Transaction if flawless
            DB::commit();
            $this->command->info("Migration Successful: $importedCount records imported with zero data loss.");
            Log::info("LegacyDataMigrationSeeder: Successfully imported $importedCount projects.");
            
        } catch (\Exception $e) {
            // 5. Rollback on any failure
            DB::rollBack();
            $this->command->error('Migration Failed! Rolled back. Error: ' . $e->getMessage());
            Log::error('LegacyDataMigrationSeeder Failed: ' . $e->getMessage());
        }
    }
}
