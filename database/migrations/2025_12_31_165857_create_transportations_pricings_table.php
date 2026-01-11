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
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('company_id')->nullable()->constrained('transportations_companies')->cascadeOnDelete();
            $table->foreignId('vehicle_type_id')->nullable()->constrained('transportations_vehicle_types')->cascadeOnDelete();
            $table->foreignId('season_id')->nullable()->constrained('seasons')->cascadeOnDelete();
            $table->foreignId('pricing_unit_id')->nullable()->constrained('pricing_definitions');
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->cascadeOnDelete();
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