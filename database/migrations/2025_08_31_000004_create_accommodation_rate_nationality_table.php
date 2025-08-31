<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationRateNationalityTable extends Migration
{
    public function up()
    {
        Schema::create('accommodation_rate_nationality', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accommodation_rate_id');
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->boolean('is_all')->default(false);
            $table->timestamps();

            $table->foreign('accommodation_rate_id')->references('id')->on('accommodation_rates')->onDelete('cascade');
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('accommodation_rate_nationality');
    }
}