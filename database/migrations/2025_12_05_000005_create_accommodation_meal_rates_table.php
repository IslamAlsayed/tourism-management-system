<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accommodation_meal_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meal_id')->constrained('meals')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();

            $table->decimal('price', 10, 2); // سعر الوجبة
            $table->boolean('is_supplement')->default(true); // هل هي إضافة أم مشمولة
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['accommodation_id', 'season_id', 'meal_id'], 'acc_season_meal_unique');
            $table->index(['accommodation_id', 'season_id'], 'acc_season_meal_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_meal_rates');
    }
};