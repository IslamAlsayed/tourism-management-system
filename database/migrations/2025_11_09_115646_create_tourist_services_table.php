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
        Schema::create('tourist_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Foreign Keys
            $table->foreignId('site_id')->constrained('tourist_sites')->onDelete('cascade');
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');

            // Service Configuration
            $table->boolean('include_unified_ticket')->default(false);
            $table->decimal('total_day_visit', 10, 2)->nullable();

            // Pricing - Foreigners
            $table->decimal('per_adult_foreigners', 10, 2)->nullable();
            $table->decimal('per_child_foreigners', 10, 2)->nullable();

            // Pricing - Local
            $table->decimal('per_adult_local', 10, 2)->nullable();
            $table->decimal('per_child_local', 10, 2)->nullable();

            // Pricing - Arab
            $table->decimal('per_adult_arab', 10, 2)->nullable();
            $table->decimal('per_child_arab', 10, 2)->nullable();

            // Pricing - Residents
            $table->decimal('per_adult_residents', 10, 2)->nullable();
            $table->decimal('per_child_residents', 10, 2)->nullable();

            // Non-accommodated Visitors
            $table->decimal('non_accommodated_visitors_adult', 10, 2)->nullable();
            $table->decimal('non_accommodated_visitors_child', 10, 2)->nullable();

            // Operating Hours
            $table->string('summer_opening_time')->nullable();
            $table->string('summer_closing_time')->nullable();
            $table->string('winter_opening_time')->nullable();
            $table->string('winter_closing_time')->nullable();
            $table->json('operating_days')->nullable();
            $table->json('annual_holidays')->nullable();
            // $table->json('special_schedules')->nullable();

            // Day Off & Holidays
            $table->json('day_off')->nullable();
            $table->json('yearly_holidays')->nullable();

            // Contact Information
            $table->string('person_name_01')->nullable();
            $table->string('person_name_02')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile_01')->nullable();
            $table->string('mobile_02')->nullable();
            $table->string('email_01')->nullable();
            $table->string('email_02')->nullable();
            $table->string('website')->nullable();

            // Local Guide
            $table->boolean('local_guide_available')->nullable()->default(false);
            $table->decimal('local_guide_fees_01', 10, 2)->nullable();
            $table->decimal('local_guide_fees_02', 10, 2)->nullable();
            $table->decimal('local_guide_fees_03', 10, 2)->nullable();
            $table->decimal('local_guide_fees_04', 10, 2)->nullable();
            $table->decimal('local_guide_fees_05', 10, 2)->nullable();

            // Payment Methods
            $table->boolean('credit_cards')->nullable()->default(false);

            // Club Cars
            $table->boolean('club_cars_available')->nullable()->default(false);
            $table->decimal('club_car_prices_01', 10, 2)->nullable();
            $table->decimal('club_car_prices_02', 10, 2)->nullable();
            $table->decimal('club_car_prices_03', 10, 2)->nullable();
            $table->decimal('club_car_prices_04', 10, 2)->nullable();
            $table->decimal('club_car_prices_05', 10, 2)->nullable();
            $table->decimal('club_car_prices_06', 10, 2)->nullable();
            $table->decimal('club_car_prices_07', 10, 2)->nullable();
            $table->decimal('club_car_prices_08', 10, 2)->nullable();

            // Additional Fields
            $table->string('ext1')->nullable();
            $table->string('ext2')->nullable();
            $table->string('ext3')->nullable();

            // Description & Notes
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // Status
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes
            $table->index('site_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_services');
    }
};