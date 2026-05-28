<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('culture_events', function (Blueprint $table) {
            if (! Schema::hasColumn('culture_events', 'is_published')) {
                // Default existing rows to true — don't surprise the editor by
                // suddenly hiding events that have been live for months.
                $table->boolean('is_published')->default(true)->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('culture_events', function (Blueprint $table) {
            if (Schema::hasColumn('culture_events', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
};
