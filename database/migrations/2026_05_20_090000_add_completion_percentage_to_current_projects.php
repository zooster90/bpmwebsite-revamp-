<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('current_projects', function (Blueprint $table) {
            if (!Schema::hasColumn('current_projects', 'completion_percentage')) {
                $table->integer('completion_percentage')->default(0)->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('current_projects', function (Blueprint $table) {
            $table->dropColumnIfExists('completion_percentage');
        });
    }
};
