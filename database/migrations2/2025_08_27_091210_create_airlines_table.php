<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('iata_code');
            $table->string('icao_code');
            $table->string('parent_airline_icao_code')->nullable();
            $table->string('marketing_name');
            $table->string('official_full_name');
            $table->string('alliance')->nullable();
            $table->string('frequent_flyer_program_name')->nullable();
            $table->string('airline_type');
            $table->string('airline_type_code');
            $table->boolean('is_lowcost')->default(false);
            $table->string('airline_home_country');
            $table->string('airline_home_country_alpha_2_code');
            $table->string('airline_home_country_alpha_3_code');
            $table->string('airline_home_city_iata_code');
            $table->integer('year_of_foundation');
            $table->string('email')->nullable();
            $table->string('official_website')->nullable();
            $table->string('baggage_policy_url')->nullable();
            $table->string('web_check_in_url')->nullable();
            $table->timestamps();
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