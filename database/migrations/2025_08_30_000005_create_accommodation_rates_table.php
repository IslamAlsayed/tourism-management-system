<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationRatesTable extends Migration
{
    public function up(): void
    {
        Schema::create('accommodation_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accommodation_id');
            $table->unsignedBigInteger('season_id')->nullable();
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
            $table->foreign('season_id')->references('id')->on('accommodation_seasons')->onDelete('set null');
            $table->foreign('room_type_id')->references('id')->on('hotel_room_types')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodation_rates');
    }
}