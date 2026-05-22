<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add internship-specific columns to culture_events table.
     * These fields are only used when category = 'intern'.
     * Grouping by year on the frontend means one page per year cohort.
     */
    public function up(): void
    {
        Schema::table('culture_events', function (Blueprint $table) {
            // Individual intern name (e.g. "Ahmad bin Ali")
            $table->string('intern_name')->nullable()->after('sub_category');
            // University or institution name
            $table->string('university')->nullable()->after('intern_name');
            // Department or faculty (e.g. "Civil Engineering")
            $table->string('department')->nullable()->after('university');
            // Internship period (e.g. "January – March 2025")
            $table->string('intern_period')->nullable()->after('department');
        });
    }

    public function down(): void
    {
        Schema::table('culture_events', function (Blueprint $table) {
            $table->dropColumn(['intern_name', 'university', 'department', 'intern_period']);
        });
    }
};
