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
        if (Schema::hasTable('pricings')) {
            return;
        }
        Schema::create('pricings', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            $table->foreignId('company_id')->nullable();
            $table->foreignId('vehicle_type_id')->nullable();
            $table->foreignId('season_id')->nullable();
            $table->foreignId('pricing_unit_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('tax')->nullable();
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricings');
    }
};
