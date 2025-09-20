<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();

            // Contacts
            $table->string('created_by')->nullable();
            $table->string('sales_man')->nullable();
            $table->string('sales_phone')->nullable();
            $table->string('sales_mail')->nullable();
            $table->string('reservation_man')->nullable();
            $table->string('reservation_phone')->nullable();
            $table->string('reservation_mail')->nullable();
            $table->string('accounting_person')->nullable();
            $table->string('accounting_mail')->nullable();
            $table->string('accounting_phone')->nullable();

            // Location
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->foreignId('region_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('subregion_id')->nullable()->constrained()->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('hotel_room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->unsignedTinyInteger('max_occupancy');
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('hotel_seasons', function (Blueprint $table) {
            $table->id();
            $table->string('season_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('hotel_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('meal_plan', ['BO', 'BB', 'HB', 'FB', 'AI'])->default('BB');
            $table->decimal('rate_per_person', 12, 2);
            $table->decimal('single_supplement', 12, 2)->nullable();

            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_season_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_type_id')->constrained('hotel_room_types')->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('hotel_supplements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->decimal('price', 12, 2);
            $table->boolean('is_per_person')->default(true);
            $table->boolean('is_mandatory')->default(false);
            $table->date('applicable_date')->nullable();

            $table->timestamps();
        });

        Schema::create('hotel_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();

            $table->string('policy_type'); // مثل: Cancellation, Child Policy
            $table->text('details');

            $table->timestamps();
        });

        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->morphs('accommodatable'); // (accommodatable_id, accommodatable_type)
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
}