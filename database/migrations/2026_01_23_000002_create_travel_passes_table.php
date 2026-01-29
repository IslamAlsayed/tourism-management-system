<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('travel_passes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('country_id')->nullable();
            $table->foreignId('currency_id')->nullable();

            // Basic Information
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->enum('pass_type', ['wanderer', 'explorer', 'expert', 'basic', 'premium', 'custom'])->default('basic');

            // Pricing
            $table->decimal('price', 10, 2)->nullable();

            // Validity
            $table->integer('validity_days')->nullable();
            $table->integer('special_attraction_days')->nullable();

            // Visa Benefits
            $table->boolean('waives_visa_fee')->default(false);
            $table->integer('min_stay_nights')->nullable();

            // Purchase Requirements
            $table->boolean('must_purchase_before_arrival')->default(true);
            $table->string('official_purchase_url', 500)->nullable();

            // Display
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);

            // Administrative
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['country_id']);
            $table->index(['pass_type']);
            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_passes');
    }
};
