<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelRatesTable extends Migration
{
    public function up()
    {
        Schema::create('hotel_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('meal_plan', ['BO', 'BB', 'HB', 'FB', 'AI'])->default('BB');
            $table->decimal('rate_per_person', 12, 2);
            $table->decimal('single_supplement', 12, 2)->nullable();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('hotel_season_id')->constrained('hotel_seasons')->onDelete('cascade');
            $table->foreignId('room_type_id')->constrained('hotel_room_types')->onDelete('cascade');
            $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hotel_rates');
    }
}