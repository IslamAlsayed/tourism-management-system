<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('special_hours')) {
            return;
        }
        Schema::create('special_hours', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->nullable();

            $table->date('date');
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('type')->default('holiday'); // holiday, seasonal_change, temporary_closure
            $table->text('description')->nullable();
            $table->boolean('is_closed')->default(false);

            $table->timestamps();
            $table->index(['tourist_service_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_hours');
    }
};
