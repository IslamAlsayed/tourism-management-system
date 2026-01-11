<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('country_state', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id');
            // $table->primary(['country_id', 'state_id']);
            // $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            // $table->foreign('state_id')->references('id')->on('states')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_state');
    }
};