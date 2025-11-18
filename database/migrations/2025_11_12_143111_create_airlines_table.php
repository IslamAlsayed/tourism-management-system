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
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();

            // Airport Codes
            $table->string('icao', 4)->unique()->nullable(); // ICAO code (4 letters)
            $table->string('iata', 3)->unique()->nullable(); // IATA code (3 letters)
            $table->string('lid', 10)->nullable(); // Local identifier

            // Airport Names
            $table->string('airport_name'); // English name
            $table->string('airport_name_ar')->nullable(); // Arabic name

            // Airport Type/Subdivision
            $table->string('subd', 50)->nullable(); // Subdivision/Type of airport

            // Location Relationships
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            // Geographic Information
            $table->decimal('elevation', 10, 2)->nullable(); // Elevation in meters
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('timezone', 50)->nullable(); // Time zone identifier

            // Contact Information
            $table->string('local_phone_number', 20)->nullable();
            $table->string('international_phone_number', 20)->nullable();
            $table->string('website')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index('icao');
            $table->index('iata');
            $table->index('airport_name');
            $table->index(['country_id', 'state_id', 'city_id']);
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airlines');
    }
};