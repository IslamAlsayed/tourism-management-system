<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tour_guide_type_city')) {
            return;
        }
        Schema::create('tour_guide_type_city', function (Blueprint $table) {
            $table->foreignId('tour_guide_type_id')->nullable();
            $table->foreignId('city_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_guide_type_city');
    }
};
