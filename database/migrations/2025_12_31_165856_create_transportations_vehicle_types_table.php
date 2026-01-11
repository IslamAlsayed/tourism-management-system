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
        Schema::create('transportations_vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('company_id')->nullable()->constrained('transportations_companies')->cascadeOnDelete();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->unsignedInteger('min_capacity')->default(1);
            $table->unsignedInteger('max_capacity')->default(1);
            $table->boolean('has_luggage')->default(false);
            $table->boolean('is_air_conditioning')->default(true);
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['name', 'name_ar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations_vehicle_types');
    }
};