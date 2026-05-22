<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Add image_url column to all content tables
 * Also adds missing columns identified during audit:
 * - image_url on projects, news, awards, culture_events, press_coverages
 * - year and name on culture_events (from Supabase 'culture' table)
 * - contract_value on projects (for flagship project details)
 * - is_available on job_openings (Supabase used this field)
 * - sort_order on job_openings
 */
return new class extends Migration
{
    public function up(): void
    {
        // --- PROJECTS ---
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'image_url')) {
                $table->string('image_url')->nullable()->after('sort_order');
            }
            if (!Schema::hasColumn('projects', 'contract_value')) {
                $table->string('contract_value')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('projects', 'client')) {
                $table->string('client')->nullable();
            }
        });

        // --- AWARDS ---
        Schema::table('awards', function (Blueprint $table) {
            if (!Schema::hasColumn('awards', 'image_url')) {
                $table->string('image_url')->nullable()->after('category');
            }
        });

        // --- NEWS ---
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'image_url')) {
                $table->string('image_url')->nullable()->after('category');
            }
            if (!Schema::hasColumn('news', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('news', 'author')) {
                $table->string('author')->nullable()->after('excerpt');
            }
            if (!Schema::hasColumn('news', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('author');
            }
        });

        // --- CULTURE EVENTS ---
        // Supabase 'culture' table had: year, name, title, description, img (JSON array)
        Schema::table('culture_events', function (Blueprint $table) {
            if (!Schema::hasColumn('culture_events', 'image_url')) {
                $table->string('image_url')->nullable()->after('description');
            }
            if (!Schema::hasColumn('culture_events', 'year')) {
                $table->integer('year')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('culture_events', 'name')) {
                $table->string('name')->nullable()->after('year');
            }
            if (!Schema::hasColumn('culture_events', 'category')) {
                $table->string('category')->nullable()->after('name');
            }
        });

        // --- PRESS COVERAGES ---
        Schema::table('press_coverages', function (Blueprint $table) {
            if (!Schema::hasColumn('press_coverages', 'image_url')) {
                $table->string('image_url')->nullable()->after('excerpt');
            }
        });

        // --- JOB OPENINGS ---
        // Supabase used 'is_available' and 'position_title' fields
        Schema::table('job_openings', function (Blueprint $table) {
            if (!Schema::hasColumn('job_openings', 'is_available')) {
                $table->boolean('is_available')->default(true)->after('is_active');
            }
            if (!Schema::hasColumn('job_openings', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_available');
            }
            if (!Schema::hasColumn('job_openings', 'requirements')) {
                $table->text('requirements')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumnIfExists('image_url');
            $table->dropColumnIfExists('contract_value');
        });
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumnIfExists('image_url');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumnIfExists('image_url');
            $table->dropColumnIfExists('excerpt');
            $table->dropColumnIfExists('author');
            $table->dropColumnIfExists('is_published');
        });
        Schema::table('culture_events', function (Blueprint $table) {
            $table->dropColumnIfExists('image_url');
            $table->dropColumnIfExists('year');
            $table->dropColumnIfExists('name');
            $table->dropColumnIfExists('category');
        });
        Schema::table('press_coverages', function (Blueprint $table) {
            $table->dropColumnIfExists('image_url');
        });
        Schema::table('job_openings', function (Blueprint $table) {
            $table->dropColumnIfExists('is_available');
            $table->dropColumnIfExists('sort_order');
            $table->dropColumnIfExists('requirements');
        });
    }
};
