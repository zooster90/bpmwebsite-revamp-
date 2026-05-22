<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add press_image_upload and gallery_uploads to press_coverages table.
 * These fields are required for the upgraded PressCoverage Filament form.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('press_coverages', function (Blueprint $table) {
            if (! Schema::hasColumn('press_coverages', 'press_image_upload')) {
                $table->string('press_image_upload')->nullable()->after('image_url');
            }
            if (! Schema::hasColumn('press_coverages', 'gallery_uploads')) {
                $table->text('gallery_uploads')->nullable()->after('press_image_upload');
            }
        });
    }

    public function down(): void
    {
        Schema::table('press_coverages', function (Blueprint $table) {
            $table->dropColumnIfExists('press_image_upload');
            $table->dropColumnIfExists('gallery_uploads');
        });
    }
};
