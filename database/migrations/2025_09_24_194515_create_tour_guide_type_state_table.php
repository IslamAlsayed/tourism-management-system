<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tour_guide_type_state', function (Blueprint $table) {
            $table->unsignedBigInteger('tour_guide_type_id');
            $table->unsignedBigInteger('state_id');
            $table->primary(['tour_guide_type_id', 'state_id']);
            $table->foreign('tour_guide_type_id')->references('id')->on('tour_guide_types')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('tour_guide_type_state');
    }
};