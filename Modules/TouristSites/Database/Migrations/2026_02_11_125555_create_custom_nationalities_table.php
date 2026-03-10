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
        if (Schema::hasTable('custom_nationalities')) {
            return;
        }
        Schema::create('custom_nationalities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('seasonal_price_id')->nullable();

            $table->foreignId('nationality_id')->nullable();
            $table->string('custom_name')->nullable(); // If custom nationality

            // Pricing matrix for this nationality
            $table->json('pricing_matrix')->nullable(); // {
            //   "adult": {"cost": 170, "commission_type": "percentage", "commission_amount": null},
            //   "child_young": {...},
            //   ...
            // }

            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->index(['seasonal_price_id', 'nationality_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_nationalities');
    }
};
