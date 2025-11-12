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
        Schema::create('air_transports', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name'); // Company/Airline name
            $table->string('name_ar')->nullable(); // Arabic name
            $table->string('code', 10)->unique(); // IATA/ICAO code (e.g., SV, EK)
            $table->text('description')->nullable();

            // Type and Category
            $table->enum('type', ['airline', 'charter_company', 'cargo_airline', 'aircraft_operator', 'aircraft_manufacturer'])->nullable()->default('airline');

            $table->enum('service_type', ['schedule', 'charter', 'cargo', 'private', 'mixed'])->default('schedule');

            // Operational Information
            $table->boolean('is_active')->default(true);
            $table->boolean('is_international')->default(true);
            $table->boolean('is_domestic')->default(true);
            $table->date('established_date')->nullable();
            $table->string('hub_airport')->nullable(); // Main hub airport code

            // Fleet Information
            $table->integer('fleet_size')->nullable();
            $table->json('aircraft_types')->nullable(); // Array of aircraft types
            $table->integer('passenger_capacity')->nullable(); // Total passenger capacity
            $table->integer('cargo_capacity')->nullable(); // Total cargo capacity in tons

            // Contact Information
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('booking_phone')->nullable();
            $table->string('customer_service_phone')->nullable();

            // Address Information
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();

            // Geographic Information
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Location Relationships
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            // Business Information
            $table->string('license_number')->nullable();
            $table->string('tax_number')->nullable();
            $table->json('certifications')->nullable(); // Array of certifications (IATA, ICAO, etc.)
            $table->json('destinations')->nullable(); // Array of destination airports/cities

            // Service Information
            $table->json('services')->nullable(); // Array of services offered
            $table->json('cabin_classes')->nullable(); // Array of cabin classes (economy, business, first)
            $table->boolean('has_frequent_flyer')->default(false);
            $table->string('frequent_flyer_program')->nullable();

            // Financial Information
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->integer('annual_passengers')->nullable();
            $table->decimal('on_time_performance', 5, 2)->nullable(); // Percentage

            // Safety and Quality
            $table->decimal('safety_rating', 3, 1)->nullable(); // Out of 5 or 7
            $table->string('safety_rating_agency')->nullable(); // Skytrax, AirlineRatings, etc.
            $table->integer('accident_count')->default(0);
            $table->date('last_safety_audit')->nullable();

            // Alliance and Partnerships
            $table->string('alliance')->nullable(); // Star Alliance, OneWorld, SkyTeam
            $table->json('partnerships')->nullable(); // Array of partner airlines
            $table->json('codeshare_agreements')->nullable(); // Array of codeshare partners

            // Status and Notes
            $table->enum('status', ['active', 'inactive', 'suspended', 'merged', 'bankrupt'])->nullable()->default('active');
            $table->text('notes')->nullable();

            // Audit Fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes for better performance
            $table->index('code');
            $table->index('type');
            $table->index('service_type');
            $table->index('status');
            $table->index('is_active');
            $table->index(['latitude', 'longitude'], 'at_coordinates_idx');
            $table->index(['country_id', 'state_id', 'city_id'], 'at_location_idx');
            $table->index('hub_airport');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_transports');
    }
};