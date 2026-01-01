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
            $table->uuid('uuid')->unique();
            $table->foreignId('timezone_id')->nullable()->constrained('timezones')->onDelete('set null');
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            $table->string('name'); // English name
            $table->string('name_ar')->nullable(); // Arabic name
            $table->string('icao', 4)->unique()->nullable(); // ICAO code (4 letters)
            $table->string('iata', 3)->unique()->nullable(); // IATA code (3 letters)
            $table->string('lid', 10)->nullable(); // Local identifier
            // Airport Type/Subdivision
            $table->string('subd', 50)->nullable(); // Subdivision/Type of airport
            // Geographic Information
            $table->decimal('elevation', 10, 2)->nullable(); // Elevation in meters
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            // Contact Information
            $table->string('local_phone_number', 20)->nullable();
            $table->string('international_phone_number', 20)->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('icao');
            $table->index('iata');
            $table->index('name');
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