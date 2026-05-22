<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general');
            $table->string('key')->unique();
            $table->string('label');
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, file, etc.
            $table->timestamps();
        });

        // Seed some initial professional settings
        DB::table('settings')->insert([
            ['group' => 'company', 'key' => 'site_name', 'label' => 'Company Name', 'value' => 'Builtech Construction', 'type' => 'text'],
            ['group' => 'company', 'key' => 'contact_email', 'label' => 'Contact Email', 'value' => 'info@builtech.com.my', 'type' => 'text'],
            ['group' => 'company', 'key' => 'contact_phone', 'label' => 'Contact Phone', 'value' => '+60 4-XXXX XXX', 'type' => 'text'],
            ['group' => 'company', 'key' => 'office_address', 'label' => 'Office Address', 'value' => '123, Jalan Builtech, Penang, Malaysia', 'type' => 'textarea'],
            ['group' => 'social', 'key' => 'facebook_url', 'label' => 'Facebook URL', 'value' => 'https://facebook.com/builtech', 'type' => 'text'],
            ['group' => 'social', 'key' => 'linkedin_url', 'label' => 'LinkedIn URL', 'value' => 'https://linkedin.com/company/builtech', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'meta_description', 'label' => 'Global Meta Description', 'value' => 'Builtech is a leading construction firm in Malaysia specializing in high-rise and industrial projects.', 'type' => 'textarea'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
