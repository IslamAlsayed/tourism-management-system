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
        Schema::create('tourist_sites', function (Blueprint $table) {
            // ========== Primary Keys & Timestamps ==========
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            // ========== Basic Information ==========
            $table->string('code')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('site_type')->nullable();
            $table->string('category')->nullable();
            $table->boolean('unesco_site')->default(false);
            $table->string('supplier_type')->nullable();
            $table->string('sites_theme')->nullable();
            $table->string('supplier_name')->nullable();
            $table->integer('sort_order')->default(0);

            // ========== Location Information ==========
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('postal_code')->nullable();

            // ========== Entry Fees ==========
            $table->decimal('entry_fee_adult', 8, 2)->nullable();
            $table->decimal('entry_fee_child', 8, 2)->nullable();
            $table->decimal('entry_fee_student', 8, 2)->nullable();
            $table->decimal('entry_fee_senior', 8, 2)->nullable();
            $table->decimal('entry_fee_group', 8, 2)->nullable();
            $table->boolean('is_free_entry')->default(false);
            $table->decimal('entry_fee_foreigner_adult', 8, 2)->nullable();
            $table->decimal('entry_fee_foreigner_child', 8, 2)->nullable();
            $table->decimal('entry_fee_arab_adult', 8, 2)->nullable();
            $table->decimal('entry_fee_arab_child', 8, 2)->nullable();
            $table->decimal('entry_fee_local_adult', 8, 2)->nullable();
            $table->decimal('entry_fee_local_child', 8, 2)->nullable();
            $table->decimal('entry_fee_resident_adult', 8, 2)->nullable();
            $table->decimal('entry_fee_resident_child', 8, 2)->nullable();

            // ========== Operating Hours ==========
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->json('operating_days')->nullable();
            $table->json('special_hours')->nullable();
            $table->boolean('is_24_7')->default(false);

            // ========== Contact Information ==========
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('website_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('fax')->nullable();
            $table->string('contact_person')->nullable();

            // ========== Facilities & Services ==========
            $table->boolean('wheelchair_accessible')->default(true);
            $table->boolean('free_wifi')->default(true);
            $table->boolean('parking')->default(true);
            $table->boolean('restrooms')->default(true);
            $table->boolean('restaurants')->default(true);
            $table->boolean('gift_shop')->default(true);
            $table->boolean('guided_tours')->default(true);
            $table->boolean('audio_guide')->default(true);
            $table->boolean('photography')->default(true);
            $table->boolean('hiking')->default(true);
            $table->boolean('swimming')->default(true);
            $table->boolean('camping')->default(true);
            $table->boolean('shopping')->default(true);
            $table->boolean('dining')->default(true);
            $table->boolean('entertainment')->default(true);
            $table->boolean('educational_tours')->default(true);
            $table->boolean('translation')->default(true);
            $table->boolean('special_events')->default(true);
            $table->boolean('group_bookings')->default(true);
            $table->boolean('online_booking')->default(true);
            $table->boolean('mobile_app')->default(true);
            $table->boolean('virtual_tours')->default(true);

            // ========== Additional Pricing ==========
            $table->decimal('local_guide_price', 8, 2)->nullable();
            $table->decimal('club_car_price', 8, 2)->nullable();
            $table->boolean('has_unified_ticket')->default(false);

            // ========== Media & Content ==========
            $table->string('photo')->nullable();
            $table->json('gallery')->nullable();
            $table->text('video_url')->nullable();
            $table->text('virtual_tour_url')->nullable();

            // ========== Visitor Information ==========
            $table->text('nearby_attractions')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->integer('popularity_score')->default(0);
            $table->integer('estimated_visit_duration')->nullable();
            $table->string('difficulty_level')->default('easy');
            $table->json('age_restrictions')->nullable();
            $table->json('best_visit_time')->nullable();

            // ========== Status & Metadata ==========
            $table->string('status')->default('active');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->json('tags')->nullable();

            // ========== Description & Notes ==========
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // ========== Audit Trail ==========
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->timestamps();

            // ========== Indexes ==========
            $table->index('name');
            $table->index('name_ar');
            $table->index('code');
            $table->index('city_id');
            $table->index('is_active');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_sites');
    }
};
