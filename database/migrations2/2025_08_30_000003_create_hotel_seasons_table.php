<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelSeasonsTable extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_seasons', function (Blueprint $table) {
            $table->id();
            $table->string('season_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            // $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_seasons');
    }
}