<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tour_guide_type_city', function (Blueprint $table) {
            $table->foreignId('tour_guide_type_id')->nullable();
            $table->foreignId('city_id')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('tour_guide_type_city');
    }
};
