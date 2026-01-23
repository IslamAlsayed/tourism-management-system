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
        Schema::create('transportations_routes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            // Route Information
            $table->string('name'); // e.g., Cairo to Alexandria
            $table->string('name_ar')->nullable(); // e.g., القاهرة إلى الإسكندرية
            $table->string('code')->unique()->nullable(); // e.g., CAI-ALX-001

            // Origin Location
            $table->foreignId('origin_city_id')->nullable()->constrained('cities')->cascadeOnDelete();
            $table->string('origin_address')->nullable();
            $table->decimal('origin_latitude', 10, 7)->nullable();
            $table->decimal('origin_longitude', 10, 7)->nullable();

            // Destination Location
            $table->foreignId('destination_city_id')->nullable()->constrained('cities')->cascadeOnDelete();
            $table->string('destination_address')->nullable();
            $table->decimal('destination_latitude', 10, 7)->nullable();
            $table->decimal('destination_longitude', 10, 7)->nullable();

            // Route Details
            $table->decimal('distance', 10, 2)->nullable(); // Distance in KM
            $table->integer('estimated_duration')->nullable(); // Duration in minutes
            $table->enum('route_type', ['one_way', 'round_trip', 'multi_stop'])->default('one_way');

            // Additional Stops (JSON for multi-stop routes)
            $table->json('waypoints')->nullable(); // [{city_id: 1, address: "...", latitude: 0, longitude: 0}]

            // Operational
            $table->boolean('is_active')->nullable();
            $table->boolean('is_toll_road')->default(false); // طريق مدفوع
            $table->decimal('toll_fee', 8, 2)->nullable();

            // Road Conditions
            $table->enum('road_condition', ['excellent', 'good', 'fair', 'poor'])->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('name_ar');
            $table->index('code');
            $table->index('origin_city_id');
            $table->index('destination_city_id');
            $table->index('route_type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations_routes');
    }
};