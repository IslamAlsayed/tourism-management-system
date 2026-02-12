<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tourist_services')) {
            return;
        }
        Schema::create('tourist_services', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            // === 1. BASIC IDENTIFICATION ===
            $table->string('code')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('service_type')->nullable(); // Renamed from site_type
            $table->string('category')->nullable();
            $table->string('supplier_type')->nullable();
            $table->string('supplier_name')->nullable();
            $table->integer('sort_order')->default(0);

            // === 2. LOCATION & GEOGRAPHY ===
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // === 3. PRICING & OPERATIONS ===
            $table->string('pricing_model')->default('per_person'); // per_person, per_group
            $table->string('pricing_type')->default('flat'); // flat vs seasonal
            $table->string('pricing_unit')->nullable(); // person, ticket, vehicle
            $table->integer('pricing_unit_value')->default(1);

            // Base Costs & Prices
            $table->decimal('cost_adult', 8, 2)->nullable();
            $table->decimal('cost_child', 8, 2)->nullable();
            $table->decimal('price_adult', 8, 2)->nullable();
            $table->decimal('price_child', 8, 2)->nullable();

            // Date Logic
            $table->json('service_seasons')->nullable(); // Array of defined seasons
            $table->json('seasonal_prices')->nullable(); // The big pricing matrix

            // Child Policy
            $table->integer('child_min_age')->nullable();
            $table->integer('child_max_age')->nullable();

            // === 4. DETAILED PRICING (Legacy Columns kept for easy queries) ===
            $table->decimal('price_foreigner_adult', 8, 2)->nullable();
            $table->decimal('price_foreigner_child', 8, 2)->nullable();
            $table->decimal('price_arab_adult', 8, 2)->nullable();
            $table->decimal('price_arab_child', 8, 2)->nullable();
            $table->decimal('price_local_adult', 8, 2)->nullable();
            $table->decimal('price_local_child', 8, 2)->nullable();
            $table->decimal('price_resident_adult', 8, 2)->nullable();
            $table->decimal('price_resident_child', 8, 2)->nullable();

            // === 5. MODULES & INTEGRATION ===
            $table->json('target_modules')->nullable(); // ['tours', 'hotels', ...]

            // === 6. TAXES & COMMISSION ===
            $table->boolean('is_tax_inclusive')->default(false);
            $table->json('tax_configuration')->nullable();
            $table->json('commission_configuration')->nullable();

            // === 7. OPERATIONS ===
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->json('operating_days')->nullable();
            $table->json('special_hours')->nullable();
            $table->boolean('is_24_7')->default(false);
            $table->integer('min_participants')->nullable();
            $table->integer('max_participants')->nullable();

            // === 8. CONTACT & FLAGS ===
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('contact_person')->nullable();
            $table->boolean('booking_required')->default(false);
            $table->text('cancellation_policy')->nullable();
            $table->boolean('is_refundable')->default(true);
            $table->boolean('is_mandatory')->default(false);
            $table->boolean('is_free')->default(false);
            $table->boolean('is_verified')->default(false);

            // === 9. MEDIA & META ===
            $table->string('photo')->nullable();
            $table->json('gallery')->nullable();
            $table->text('video_url')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->integer('duration_minutes')->nullable();
            $table->string('difficulty_level')->default('easy');
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('name_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourist_services');
    }
};
