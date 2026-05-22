<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // culture_events: add is_published + location + sub_category
        Schema::table('culture_events', function (Blueprint $table) {
            if (!Schema::hasColumn('culture_events', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('gallery_uploads');
            }
            if (!Schema::hasColumn('culture_events', 'location')) {
                $table->string('location')->nullable()->after('is_published');
            }
            if (!Schema::hasColumn('culture_events', 'sub_category')) {
                $table->string('sub_category')->nullable()->after('location');
            }
        });

        // awards: add title column (Supabase uses 'title', Laravel created 'name')
        Schema::table('awards', function (Blueprint $table) {
            if (!Schema::hasColumn('awards', 'title')) {
                $table->string('title')->nullable()->after('name');
            }
            if (!Schema::hasColumn('awards', 'award_date')) {
                $table->date('award_date')->nullable()->after('title');
            }
            if (!Schema::hasColumn('awards', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('award_date');
            }
        });

        // press_coverages: ensure all needed columns exist
        Schema::table('press_coverages', function (Blueprint $table) {
            if (!Schema::hasColumn('press_coverages', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('image_url');
            }
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
        Schema::table('culture_events', function (Blueprint $table) {
            $table->dropColumnIfExists('is_published');
            $table->dropColumnIfExists('location');
            $table->dropColumnIfExists('sub_category');
        });
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumnIfExists('title');
            $table->dropColumnIfExists('award_date');
            $table->dropColumnIfExists('is_published');
        });
        Schema::table('press_coverages', function (Blueprint $table) {
            $table->dropColumnIfExists('is_published');
        });
    }
};
