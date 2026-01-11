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

            $table->string('code')->nullable();
            $table->string('name');
            $table->string('name_ar')->nullable();

            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->string('site_type')->nullable();
            $table->string('category')->nullable();
            $table->boolean('translation')->nullable();
            $table->boolean('special_events')->nullable();
            $table->boolean('group_bookings')->nullable();
            $table->boolean('online_booking')->nullable();
            $table->boolean('mobile_app')->nullable();
            $table->boolean('virtual_tours')->nullable();
            $table->boolean('has_parking')->nullable();
            $table->boolean('has_restaurant')->nullable();
            $table->boolean('has_gift_shop')->nullable();
            $table->boolean('has_restrooms')->nullable();
            $table->string('photo')->nullable();
            $table->string('main_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('video_url')->nullable();
            $table->string('virtual_tour_url')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('total_reviews')->nullable();
            $table->integer('popularity_score')->nullable();
            $table->integer('estimated_visit_duration')->nullable();
            $table->string('difficulty_level')->nullable();
            $table->json('age_restrictions')->nullable();
            $table->json('best_visit_time')->nullable();
            $table->json('tags')->nullable();
            $table->string('address')->nullable();
            $table->string('area')->nullable();
            $table->string('zone')->nullable();
            $table->string('district')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('block')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('apartment')->nullable();
            $table->string('landmark')->nullable();
            $table->string('directions')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->string('ticket_type')->nullable();
            $table->decimal('ticket_price', 10, 2)->nullable();
            $table->decimal('ticket_price_children', 10, 2)->nullable();
            $table->decimal('ticket_price_students', 10, 2)->nullable();
            $table->decimal('ticket_price_seniors', 10, 2)->nullable();
            $table->decimal('ticket_price_groups', 10, 2)->nullable();
            $table->json('ticket_options')->nullable();
            $table->json('discounts')->nullable();
            $table->json('special_offers')->nullable();
            $table->json('opening_hours')->nullable();
            $table->json('holiday_hours')->nullable();
            $table->json('closed_dates')->nullable();
            $table->json('event_schedules')->nullable();
            $table->json('facilities')->nullable();
            $table->json('accessibility_features')->nullable();
            $table->json('safety_features')->nullable();
            $table->json('health_measures')->nullable();
            $table->json('covid_measures')->nullable();
            $table->json('services')->nullable();
            $table->json('activities')->nullable();
            $table->json('events')->nullable();
            $table->json('workshops')->nullable();
            $table->json('tours')->nullable();
            $table->json('programs')->nullable();
            $table->json('packages')->nullable();
            $table->json('media_files')->nullable();
            $table->json('documents')->nullable();
            $table->json('links')->nullable();
            $table->json('brochures')->nullable();
            $table->json('menus')->nullable();
            $table->json('maps')->nullable();
            $table->json('translations')->nullable();
            $table->json('custom_fields')->nullable();
            $table->json('extra')->nullable();
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->timestamp('last_imported_at')->nullable();
            $table->timestamp('last_exported_at')->nullable();
            $table->json('import_metadata')->nullable();
            $table->json('export_metadata')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_featured')->nullable();
            $table->boolean('is_verified')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index('name');
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