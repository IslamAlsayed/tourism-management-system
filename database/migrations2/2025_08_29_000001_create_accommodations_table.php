<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // hotel, resort, camp, chalet, apartment, etc.
            $table->string('trade_name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('city_name')->nullable();
            $table->string('region')->nullable();
            $table->string('street')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('classification')->nullable();
            $table->unsignedTinyInteger('star_rating')->nullable();
            $table->string('cat')->nullable();
            $table->string('general_mobile')->nullable();
            $table->string('general_email')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_ext')->nullable();
            $table->string('fax')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_position')->nullable();
            $table->string('contact_mobile')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('description')->nullable();
            $table->string('contract_file_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('accommodation_seasons', function (Blueprint $table) {
            $table->id();
            $table->string('season_name');
            $table->boolean('is_special')->default(false);
            $table->string('special_type')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('accommodation_id')->nullable();
            $table->timestamps();
        });

        Schema::create('accommodation_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedBigInteger('accommodation_id')->nullable();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->timestamps();
        });

        Schema::create('accommodation_rate_nationality', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accommodation_rate_id');
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->boolean('is_all')->default(false);
            $table->timestamps();

            $table->foreign('accommodation_rate_id')->references('id')->on('accommodation_rates')->onDelete('cascade');
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
        });

        Schema::create('accommodation_supplements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_per_person')->default(false);
            $table->boolean('is_mandatory')->default(false);
            $table->date('applicable_date')->nullable();
            $table->unsignedBigInteger('accommodation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
}