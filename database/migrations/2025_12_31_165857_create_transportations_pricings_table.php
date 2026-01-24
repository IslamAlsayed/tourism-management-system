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
        Schema::create('transportations_pricings', function (Blueprint $table) {
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
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations_pricings');
    }
};
