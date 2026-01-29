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
        Schema::create('jeeps', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Trip/Route Info
            $table->string('route');
            $table->string('route_ar');
            $table->string('slug')->unique();

            // Start & End Points
            // $table->string('start_point')->nullable();
            // $table->string('end_point')->nullable();
            $table->foreignId('origin_city_id')->nullable();
            $table->foreignId('destination_city_id')->nullable();
            $table->json('route_itinerary')->nullable();

            // Location Relations
            $table->foreignId('region_id')->nullable();
            $table->foreignId('subregion_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();

            // Company Relation (New)
            $table->foreignId('company_id')->nullable();

            // Trip Details
            $table->decimal('duration', 8, 2)->nullable(); // Changed to decimal for calculation
            $table->enum('duration_unit', ['hours', 'minutes', 'days'])->default('hours'); // New

            $table->decimal('distance', 8, 2)->nullable(); // Changed to decimal
            $table->enum('distance_unit', ['km', 'miles'])->default('km'); // New

            $table->integer('car_seats')->default(4);

            // Pricing
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->enum('price_type', ['per_person', 'per_trip', 'per_vehicle', 'per_hour'])->default('per_vehicle');

            // Vehicle Details
            $table->string('vehicle_model')->nullable();
            $table->string('model_year')->nullable();
            $table->string('license_plate')->nullable();

            $table->boolean('has_ac')->default(true);
            $table->boolean('has_driver')->default(true);
            $table->boolean('is_4x4')->default(true);
            $table->boolean('has_camping_gear')->default(false);

            // Media
            $table->string('photo')->nullable();
            $table->json('gallery')->nullable();

            // Status & Timestamps
            $table->enum('status', ['active', 'maintenance', 'retired'])->default('active');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jeeps');
    }
};