<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tourist_sites', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Location Information
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            // Site Information
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('site_type')->nullable();
            $table->boolean('unesco_site')->default(false);
            $table->string('supplier_type')->nullable();
            $table->string('sites_theme')->nullable();
            $table->string('supplier_name')->nullable();

            // Coordinates
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Description & Nearby
            $table->text('description')->nullable();
            $table->text('nearby_attractions')->nullable();

            // Images
            $table->string('main_image')->nullable();
            $table->json('gallery_images')->nullable();

            // Status
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('name_ar');
            $table->index('city_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_sites');
    }
};