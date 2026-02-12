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
        if (Schema::hasTable('tour_guide_type_state')) {
            return;
        }
        Schema::create('tour_guide_type_state', function (Blueprint $table) {
            $table->foreignId('tour_guide_type_id')->nullable();
            $table->foreignId('state_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_guide_type_state');
    }
};
