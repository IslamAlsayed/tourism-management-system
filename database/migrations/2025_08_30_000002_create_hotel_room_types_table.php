<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelRoomTypesTable extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->string('name_ar');
            $table->string('name_en');
            $table->unsignedTinyInteger('max_occupancy');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_room_types');
    }
}