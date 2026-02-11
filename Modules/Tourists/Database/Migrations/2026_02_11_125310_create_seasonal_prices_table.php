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
        Schema::create('seasonal_prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->nullable();

            // Season info
            $table->string('season_name')->default('Standard'); // "Standard", "High Season", etc.
            $table->date('season_start_date')->nullable();
            $table->date('season_end_date')->nullable();

            // Full pricing matrix as JSON for flexibility
            $table->json('pricing_matrix')->nullable(); // {
            //   "adult": {
            //     "foreigner": {"cost": 89, "commission": 1},
            //     "arab": {...},
            //     ...
            //   },
            //   "child_young": {...},
            //   "child_older": {...},
            //   "infant": {...},
            //   "custom_nationalities": [...]
            // }

            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->index(['tourist_service_id', 'season_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seasonal_prices');
    }
};
