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
        Schema::create('crossing_ports', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable(); // ICAO code for airports, custom code for others

            // Basic information
            $table->string('name'); // Name in English
            $table->string('name_ar')->nullable(); // Name in Arabic
            $table->text('description')->nullable();

            // Location information
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            // Type of crossing/port
            $table->enum('type', ['land_crossing', 'international_airport', 'domestic_airport', 'seaport', 'river_port', 'border_crossing']);

            // Coordinates
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('elevation')->nullable(); // For airports

            // Operating information
            $table->boolean('is_operational')->default(true);
            $table->boolean('is_24_hours')->default(false);
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->json('operating_days')->nullable(); // Days of week

            // Facilities and services
            $table->json('facilities')->nullable(); // Customs, immigration, quarantine, etc.
            $table->json('services')->nullable(); // VIP services, cargo handling, etc.

            // Contact information
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();

            // Additional information
            $table->integer('capacity')->nullable(); // Passengers per hour/day
            $table->json('runway_info')->nullable(); // For airports - runway length, surface type
            $table->string('customs_office')->nullable();
            $table->string('immigration_office')->nullable();

            // Status and preferences
            $table->enum('status', ['active', 'inactive', 'under_construction', 'maintenance'])->nullable()->default('active');
            $table->text('notes')->nullable();

            // Images and documents
            $table->json('images')->nullable();
            $table->json('documents')->nullable();

            // Tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index('code');
            $table->index('type');
            $table->index('status');
            $table->index(['latitude', 'longitude'], 'cp_coordinates_index');
            $table->index(['region_id', 'subregion_id', 'country_id', 'state_id', 'city_id'], 'cp_location_index');
            $table->index('is_operational');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crossing_ports');
    }
};
