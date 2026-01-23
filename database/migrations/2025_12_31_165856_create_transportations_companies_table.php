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
        Schema::create('transportations_companies', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            // Foreign Keys
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->nullOnDelete();
            $table->foreignId('region_id')->nullable()->constrained('regions')->nullOnDelete();
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->nullOnDelete();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('state_id')->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->string('name')->nullable(); // e.g., Hilton Cairo, Bedouin Camp, other
            $table->string('name_ar')->nullable(); // e.g., هيلتون القاهرة، مخيم بدوي، أخرى
            $table->string('code')->nullable();
            $table->decimal('rating', 2, 1)->nullable(); // 4.5

            $table->string('street')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('website')->nullable();

            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('name_ar');
            $table->index('is_active');
            $table->index('country_id');
            $table->index('city_id');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations_companies');
    }
};