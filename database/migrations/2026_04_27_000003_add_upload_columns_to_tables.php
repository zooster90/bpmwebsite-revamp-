<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // --- PROJECTS ---
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'cover_image_upload')) {
                $table->string('cover_image_upload')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('projects', 'gallery_uploads')) {
                $table->text('gallery_uploads')->nullable()->after('cover_image_upload'); // Text for JSON/Array
            }
        });

        // --- AWARDS ---
        Schema::table('awards', function (Blueprint $table) {
            if (!Schema::hasColumn('awards', 'logo_upload')) {
                $table->string('logo_upload')->nullable()->after('image_url');
            }
        });

        // --- NEWS ---
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'news_image_upload')) {
                $table->string('news_image_upload')->nullable()->after('image_url');
            }
        });

        // --- CULTURE EVENTS ---
        Schema::table('culture_events', function (Blueprint $table) {
            if (!Schema::hasColumn('culture_events', 'culture_image_upload')) {
                $table->string('culture_image_upload')->nullable()->after('image_url');
            }
        });

        // --- CURRENT PROJECTS ---
        Schema::table('current_projects', function (Blueprint $table) {
            if (!Schema::hasColumn('current_projects', 'image_upload')) {
                $table->string('image_upload')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('current_projects', 'gallery_uploads')) {
                $table->text('gallery_uploads')->nullable()->after('image_upload');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['cover_image_upload', 'gallery_uploads']);
        });
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumn('logo_upload');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('news_image_upload');
        });
        Schema::table('culture_events', function (Blueprint $table) {
            $table->dropColumn('culture_image_upload');
        });
        Schema::table('current_projects', function (Blueprint $table) {
            $table->dropColumn(['image_upload', 'gallery_uploads']);
        });
    }
};
