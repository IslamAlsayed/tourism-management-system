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
        Schema::create('transportations_route_assignments', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            // Relations
            $table->foreignId('route_id')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->foreignId('vehicle_type_id')->nullable();

            // Pricing for this route assignment
            $table->foreignId('currency_id')->nullable();
            $table->decimal('base_price', 10, 2)->nullable(); // Base price for the route
            $table->decimal('price_per_km', 10, 2)->nullable(); // Price per kilometer
            $table->decimal('price_per_person', 10, 2)->nullable(); // Price per person

            // Schedule
            $table->json('available_days')->nullable(); // [0,1,2,3,4,5,6] for Sunday to Saturday
            $table->time('departure_time')->nullable();
            $table->time('arrival_time')->nullable();
            $table->integer('frequency_per_day')->default(1); // How many trips per day

            // Operational
            $table->boolean('is_active')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();

            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('route_id');
            $table->index('company_id');
            $table->index('vehicle_type_id');
            $table->index('is_active');
            $table->index(['valid_from', 'valid_to']);

            // Unique constraint with custom name
            $table->unique(['route_id', 'company_id', 'vehicle_type_id'], 'route_company_vehicle_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations_route_assignments');
    }
};
