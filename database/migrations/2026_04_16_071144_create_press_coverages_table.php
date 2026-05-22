<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('press_coverages', function (Blueprint $table) {
            $table->id();
            $table->string('headline');
            $table->string('publication')->nullable();
            $table->date('published_date')->nullable();
            $table->string('external_url')->nullable();
            $table->text('excerpt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('press_coverages');
    }
};
