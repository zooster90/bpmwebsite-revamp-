<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update both main category and subcategories
        DB::table('categories')
            ->where('model_type', 'CultureEvent')
            ->where('slug', 'intern')
            ->update(['name' => 'Internship']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')
            ->where('model_type', 'CultureEvent')
            ->where('slug', 'intern')
            ->update(['name' => 'intern']);
    }
};
