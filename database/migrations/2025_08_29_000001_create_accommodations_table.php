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
            $table->string('name_en')->nullable();
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
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
}