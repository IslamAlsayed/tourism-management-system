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
        Schema::create('pricing_definitions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            $table->string('key')->unique(); // per_person, per_day, fixed, per_trip, per_km
            $table->string('name'); // Per Person, Per Day, Fixed Price
            $table->string('name_ar')->nullable(); // لكل شخص، لكل يوم، سعر ثابت

            $table->enum('category', [
                'pricing_type', // fixed / per_person
                'pricing_unit', // per_day / per_trip
            ])->nullable();

            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['key', 'name', 'name_ar', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_definitions');
    }
};