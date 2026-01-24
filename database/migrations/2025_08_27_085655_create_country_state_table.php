<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('country_state', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_state');
    }
};
