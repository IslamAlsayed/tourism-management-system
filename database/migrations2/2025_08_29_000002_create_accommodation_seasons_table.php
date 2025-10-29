<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationSeasonsTable extends Migration
{
    public function up(): void
    {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodation_seasons');
    }
}