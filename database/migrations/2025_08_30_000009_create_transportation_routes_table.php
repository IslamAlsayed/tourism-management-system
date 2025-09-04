<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationRoutesTable extends Migration
{
    public function up()
    {
        Schema::create('transportation_routes', function (Blueprint $table) {
            $table->id();
            $table->string('start_location');
            $table->string('end_location');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transportation_routes');
    }
}