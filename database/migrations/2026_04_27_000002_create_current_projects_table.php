<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the current_projects table.
 * This was a separate table in Supabase from 'projects',
 * used specifically for displaying "active/featured" projects
 * on the homepage and other prominent sections.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('current_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('location')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->default('Ongoing');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('client')->nullable();
            $table->integer('year')->nullable();
            $table->string('contract_value')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('current_projects');
    }
};
