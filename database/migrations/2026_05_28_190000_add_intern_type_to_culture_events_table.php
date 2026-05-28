<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds `intern_type` to culture_events so admins can mark each intern
 * record as either a "site" intern or an "office" intern. The frontend
 * splits the year cohort into separate Site / Office sections, and the
 * "Total Interns" count only includes records where intern_type is set
 * (so cohort group photos like "Internship Farewell" no longer inflate
 * the number).
 *
 * Nullable on purpose: existing rows stay null until admin edits them,
 * which is also how a record opts-in to the "Cohort Highlights" strip.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('culture_events', function (Blueprint $table) {
            if (! Schema::hasColumn('culture_events', 'intern_type')) {
                $table->string('intern_type', 16)
                    ->nullable()
                    ->after('department');
            }
        });
    }

    public function down(): void
    {
        Schema::table('culture_events', function (Blueprint $table) {
            if (Schema::hasColumn('culture_events', 'intern_type')) {
                $table->dropColumn('intern_type');
            }
        });
    }
};
