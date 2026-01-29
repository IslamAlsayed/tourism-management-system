<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jeep_seasons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('jeep_id');

            $table->string('name'); // e.g., Summer 2026
            $table->date('start_date');
            $table->date('end_date');

            // Base Prices for Categories
            $table->decimal('price_local', 10, 2)->default(0);
            $table->decimal('price_arab', 10, 2)->default(0);
            $table->decimal('price_foreigner', 10, 2)->default(0);

            $table->timestamps();
        });

        Schema::create('jeep_season_nationality_prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('jeep_season_id');

            // Link to system Nationality
            $table->foreignId('nationality_id');

            // Specific Price
            $table->decimal('price', 10, 2);
            $table->string('price_type')->default('per_vehicle');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jeep_season_nationality_prices');
        Schema::dropIfExists('jeep_seasons');
    }
};
