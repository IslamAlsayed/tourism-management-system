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
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            // Location References
            $table->foreignId('timezone_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();
            // Airline Identification
            $table->string('iata_code', 3)->nullable()->unique();
            $table->string('icao_code', 4)->nullable()->unique();
            $table->string('parent_airline_icao_code', 4)->nullable();

            // Airline Names & Branding
            $table->string('marketing_name')->nullable();
            $table->string('official_full_name')->nullable();
            $table->string('alliance')->nullable();
            $table->string('frequent_flyer_program_name')->nullable();

            // Airline Classification
            $table->string('airline_type')->nullable(); // e.g., "Full Service", "Low Cost", "Regional"
            $table->string('airline_type_code')->nullable(); // e.g., "FSC", "LCC", "REG"
            $table->boolean('is_lowcost')->default(false)->nullable();

            // Home Country Information
            $table->string('airline_home_country')->nullable();
            $table->string('airline_home_country_alpha_2_code', 2)->nullable(); // ISO 3166-1 alpha-2
            $table->string('airline_home_country_alpha_3_code', 3)->nullable(); // ISO 3166-1 alpha-3
            $table->string('airline_home_city_iata_code', 3)->nullable();

            // Organization Details
            $table->integer('year_of_foundation')->nullable();
            $table->string('email')->nullable();
            $table->text('official_website')->nullable();
            $table->text('baggage_policy_url')->nullable();
            $table->text('web_check_in_url')->nullable();

            // Contact Information
            $table->string('local_phone_number', 20)->nullable();
            $table->string('international_phone_number', 20)->nullable();

            // Additional Information
            $table->boolean('is_active')->default(true)->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index('iata_code');
            $table->index('icao_code');
            $table->index('airline_home_country_alpha_2_code');
            $table->index('is_lowcost');
            $table->index(['country_id', 'state_id', 'city_id']);
            $table->index('is_active');
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
