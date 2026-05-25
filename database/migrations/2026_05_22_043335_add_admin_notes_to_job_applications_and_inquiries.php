<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add admin_notes to job_applications
        Schema::table('job_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('job_applications', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('cover_letter');
            }
        });

        // Add admin_notes + archived_at + category to inquiries
        Schema::table('inquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('inquiries', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('message');
            }
            if (!Schema::hasColumn('inquiries', 'archived_at')) {
                $table->timestamp('archived_at')->nullable()->after('admin_notes');
            }
            if (!Schema::hasColumn('inquiries', 'category')) {
                $table->string('category')->nullable()->after('subject');
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn('admin_notes');
        });
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['admin_notes', 'archived_at', 'category']);
        });
    }
};
