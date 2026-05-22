<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('press_coverages', function (Blueprint $table) {
            if (!Schema::hasColumn('press_coverages', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_published');
            }
            if (!Schema::hasColumn('press_coverages', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('sort_order');
            }
            if (!Schema::hasColumn('press_coverages', 'category')) {
                $table->string('category')->nullable()->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('press_coverages', function (Blueprint $table) {
            $table->dropColumnIfExists('sort_order');
            $table->dropColumnIfExists('is_featured');
            $table->dropColumnIfExists('category');
        });
    }
};
