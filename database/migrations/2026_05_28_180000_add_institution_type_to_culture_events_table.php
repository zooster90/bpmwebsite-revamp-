<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds an `institution_type` enum-ish string column so the public intern
 * card can render a context-appropriate icon next to the institution name
 * (university, polytechnic, school, site, training centre, etc.).
 *
 * Default 'university' preserves the current display for all existing rows.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('culture_events', function (Blueprint $table) {
            if (! Schema::hasColumn('culture_events', 'institution_type')) {
                $table->string('institution_type', 32)
                    ->nullable()
                    ->default('university')
                    ->after('university');
            }
        });
    }

    public function down(): void
    {
        Schema::table('culture_events', function (Blueprint $table) {
            if (Schema::hasColumn('culture_events', 'institution_type')) {
                $table->dropColumn('institution_type');
            }
        });
    }
};
