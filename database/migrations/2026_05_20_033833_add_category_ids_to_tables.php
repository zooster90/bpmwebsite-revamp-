<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'projects' => 'Project',
            'current_projects' => 'Project',
            'awards' => 'Award',
            'news' => 'News',
            'press_coverages' => 'News',
            'culture_events' => 'CultureEvent',
        ];

        // 1. Add category_id and sub_category_id
        foreach ($tables as $table => $modelType) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (!Schema::hasColumn($table, 'category_id')) {
                    $t->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                }
                if ($table === 'culture_events' && !Schema::hasColumn($table, 'sub_category_id')) {
                    $t->foreignId('sub_category_id')->nullable()->constrained('categories')->nullOnDelete();
                }
            });
        }

        // 2. Migrate Data
        foreach ($tables as $table => $modelType) {
            if (Schema::hasColumn($table, 'category')) {
                $records = DB::table($table)->whereNotNull('category')->get();
                foreach ($records as $record) {
                    $categoryName = $record->category;
                    if (empty($categoryName)) continue;

                    // Ensure category exists
                    $category = Category::firstOrCreate(
                        ['slug' => Str::slug($categoryName), 'model_type' => $modelType],
                        ['name' => $categoryName]
                    );

                    $updateData = ['category_id' => $category->id];

                    if ($table === 'culture_events' && !empty($record->sub_category)) {
                        $subCategoryName = $record->sub_category;
                        $subCategory = Category::firstOrCreate(
                            ['slug' => Str::slug($subCategoryName), 'model_type' => $modelType, 'parent_id' => $category->id],
                            ['name' => $subCategoryName]
                        );
                        $updateData['sub_category_id'] = $subCategory->id;
                    }

                    DB::table($table)->where('id', $record->id)->update($updateData);
                }
            }
        }

        // 3. Drop old string columns
        foreach ($tables as $table => $modelType) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'category')) {
                    $t->dropColumn('category');
                }
                if ($table === 'culture_events' && Schema::hasColumn($table, 'sub_category')) {
                    $t->dropColumn('sub_category');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'projects',
            'current_projects',
            'awards',
            'news',
            'press_coverages',
            'culture_events',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'category_id')) {
                    $t->dropForeign(['category_id']);
                    $t->dropColumn('category_id');
                }
                if ($table === 'culture_events' && Schema::hasColumn($table, 'sub_category_id')) {
                    $t->dropForeign(['sub_category_id']);
                    $t->dropColumn('sub_category_id');
                }
                
                if (!Schema::hasColumn($table, 'category')) {
                    $t->string('category')->nullable();
                }
                if ($table === 'culture_events' && !Schema::hasColumn($table, 'sub_category')) {
                    $t->string('sub_category')->nullable();
                }
            });
        }
    }
};
