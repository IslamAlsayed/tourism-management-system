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
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('site_code')->unique()->nullable();

            // Basic Information
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('site_type')->nullable();
            $table->string('category')->nullable();

            // Location Information
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            // Geographical Details
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('postal_code')->nullable();

            // Entry Information
            $table->decimal('entry_fee_adult', 8, 2)->nullable();
            $table->decimal('entry_fee_child', 8, 2)->nullable();
            $table->decimal('entry_fee_student', 8, 2)->nullable();
            $table->decimal('entry_fee_senior', 8, 2)->nullable();
            $table->decimal('entry_fee_group', 8, 2)->nullable();
            $table->boolean('is_free_entry')->default(false);

            // Operating Hours
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->json('operating_days')->nullable(); // [1,2,3,4,5,6,7] for days of week
            $table->json('special_hours')->nullable(); // Special hours for holidays, etc.
            $table->boolean('is_24_hours')->default(false);

            // Contact Information
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('website_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();

            // Facilities
            $table->boolean('wheelchair_accessible')->default(true);
            $table->boolean('free_wifi')->default(true);
            $table->boolean('parking')->default(true);
            $table->boolean('restrooms')->default(true);
            $table->boolean('restaurants')->default(true);
            $table->boolean('gift_shop')->default(true);
            $table->boolean('guided_tours')->default(true);
            $table->boolean('audio_guide')->default(true);

            // Activities
            $table->boolean('photography')->default(true);
            $table->boolean('hiking')->default(true);
            $table->boolean('swimming')->default(true);
            $table->boolean('camping')->default(true);
            $table->boolean('shopping')->default(true);
            $table->boolean('dining')->default(true);
            $table->boolean('entertainment')->default(true);
            $table->boolean('educational_tours')->default(true);

            // Services
            $table->boolean('translation')->default(true);
            $table->boolean('special_events')->default(true);
            $table->boolean('group_bookings')->default(true);
            $table->boolean('online_booking')->default(true);
            $table->boolean('mobile_app')->default(true);
            $table->boolean('virtual_tours')->default(true);

            // Accessibility & Amenities
            $table->boolean('has_parking')->default(true);
            $table->boolean('has_restaurant')->default(true);
            $table->boolean('has_gift_shop')->default(true);
            $table->boolean('has_restrooms')->default(true);

            // Media & Resources
            $table->string('photo')->nullable();
            $table->text('main_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->text('video_url')->nullable();
            $table->text('virtual_tour_url')->nullable();

            // Ratings & Reviews
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->integer('popularity_score')->default(0);

            // Visitor Information
            $table->integer('estimated_visit_duration')->nullable(); // in minutes
            $table->enum('difficulty_level', ['easy', 'moderate', 'challenging', 'extreme'])->default('easy');
            $table->json('age_restrictions')->nullable();
            $table->json('best_visit_time')->nullable(); // seasons, months, etc.

            // Administrative
            $table->enum('status', ['active', 'inactive', 'maintenance', 'permanently_closed'])->nullable()->default('active');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->json('tags')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // Tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('site_type');
            $table->index('category');
            $table->index('status');
            $table->index(['country_id', 'state_id', 'city_id']);
            $table->index(['latitude', 'longitude']);
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