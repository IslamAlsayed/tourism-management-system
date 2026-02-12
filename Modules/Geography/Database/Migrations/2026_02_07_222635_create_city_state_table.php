<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('city_state')) {
            return;
        }
        Schema::create('city_state', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable();
            $table->foreignId('state_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_state');
    }
};
