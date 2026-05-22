<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'gallery_uploads')) {
                $table->text('gallery_uploads')->nullable()->after('news_image_upload');
            }
        });

        Schema::table('culture_events', function (Blueprint $table) {
            if (!Schema::hasColumn('culture_events', 'gallery_uploads')) {
                $table->text('gallery_uploads')->nullable()->after('culture_image_upload');
            }
        });

        Schema::table('awards', function (Blueprint $table) {
            if (!Schema::hasColumn('awards', 'gallery_uploads')) {
                $table->text('gallery_uploads')->nullable()->after('logo_upload');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('gallery_uploads');
        });
        Schema::table('culture_events', function (Blueprint $table) {
            $table->dropColumn('gallery_uploads');
        });
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumn('gallery_uploads');
        });
    }
};
