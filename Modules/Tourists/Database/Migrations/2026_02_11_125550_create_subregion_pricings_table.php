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
        if (Schema::hasTable('subregion_pricing')) {
            return;
        }
        Schema::create('subregion_pricing', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('seasonal_price_id')->nullable();
            $table->foreignId('city_id')->nullable();

            $table->string('subregion_name')->nullable(); // Custom region name
            $table->decimal('adult_cost', 8, 2)->nullable();
            $table->decimal('adult_price', 8, 2)->nullable();
            $table->decimal('child_cost', 8, 2)->nullable();
            $table->decimal('child_price', 8, 2)->nullable();

            // Override pricing matrix if needed
            $table->json('pricing_override')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->index(['seasonal_price_id', 'city_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subregion_pricings');
    }
};
