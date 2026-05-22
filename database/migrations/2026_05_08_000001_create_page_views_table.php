<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->string('page_title', 300)->nullable();
            $table->string('route_name', 150)->nullable();
            $table->string('session_id', 100)->nullable()->index();
            $table->string('ip_address', 45)->nullable();   // anonymised (last octet removed)
            $table->string('user_agent', 500)->nullable();
            $table->string('browser', 80)->nullable();
            $table->string('browser_version', 40)->nullable();
            $table->string('os', 80)->nullable();
            $table->string('device_type', 30)->nullable();  // desktop | mobile | tablet
            $table->string('referrer', 500)->nullable();
            $table->string('country', 100)->nullable();
            $table->integer('time_on_page')->nullable();    // seconds, updated on leave
            $table->boolean('is_bounce')->default(false);
            $table->timestamps();

            $table->index('created_at');
            $table->index(['url', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
