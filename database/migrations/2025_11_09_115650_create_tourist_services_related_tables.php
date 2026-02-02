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
        // === SEASONAL PRICES TABLE ===
        Schema::create('seasonal_prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->constrained('tourist_services')->onDelete('cascade');

            // Season info
            $table->string('season_name')->default('Standard'); // "Standard", "High Season", etc.
            $table->date('season_start_date')->nullable();
            $table->date('season_end_date')->nullable();

            // Full pricing matrix as JSON for flexibility
            $table->json('pricing_matrix')->nullable(); // {
            //   "adult": {
            //     "foreigner": {"cost": 89, "commission": 1},
            //     "arab": {...},
            //     ...
            //   },
            //   "child_young": {...},
            //   "child_older": {...},
            //   "infant": {...},
            //   "custom_nationalities": [...]
            // }

            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->index(['tourist_service_id', 'season_name']);
        });

        // === TAX CONFIGURATIONS TABLE ===
        Schema::create('tax_configurations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->constrained('tourist_services')->onDelete('cascade');

            $table->string('name'); // e.g., "VAT", "Service Tax"
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 8, 2); // e.g., 15.00 for 15%
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->index('tourist_service_id');
        });

        // === COMMISSION CONFIGURATIONS TABLE ===
        Schema::create('commission_configurations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->constrained('tourist_services')->onDelete('cascade');

            $table->string('name'); // e.g., "Agent Commission"
            $table->enum('applies_to', ['all', 'foreigner', 'arab', 'resident'])->default('all');
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 8, 2);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->index(['tourist_service_id', 'applies_to']);
        });

        // === TARGET MODULES TABLE ===
        Schema::create('tourist_service_modules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->constrained('tourist_services')->onDelete('cascade');

            $table->string('module_name'); // accommodations, food, activities, etc.
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->unique(['tourist_service_id', 'module_name']);
            $table->index('tourist_service_id');
        });

        // === GALLERY/MEDIA FILES TABLE ===
        Schema::create('tourist_service_media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->constrained('tourist_services')->onDelete('cascade');

            $table->string('file_name'); // Original file name
            $table->string('file_path'); // Storage path
            $table->string('file_type')->default('image'); // image, video, document
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size')->nullable();

            $table->string('alt_text')->nullable(); // For SEO
            $table->text('description')->nullable();

            $table->boolean('is_primary')->default(false); // Main photo
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->index(['tourist_service_id', 'file_type']);
        });

        // === SUBREGION PRICING TABLE (For location-based pricing) ===
        Schema::create('subregion_pricing', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('seasonal_price_id')->constrained('seasonal_prices')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities');

            $table->string('subregion_name')->nullable(); // Custom region name
            $table->decimal('adult_cost', 8, 2)->nullable();
            $table->decimal('adult_price', 8, 2)->nullable();
            $table->decimal('child_cost', 8, 2)->nullable();
            $table->decimal('child_price', 8, 2)->nullable();

            // Override pricing matrix if needed
            $table->json('pricing_override')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->index(['seasonal_price_id', 'city_id']);
        });

        // === CUSTOM NATIONALITIES TABLE ===
        Schema::create('custom_nationalities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('seasonal_price_id')->constrained('seasonal_prices')->onDelete('cascade');

            $table->foreignId('nationality_id')->nullable()->constrained('nationalities');
            $table->string('custom_name')->nullable(); // If custom nationality

            // Pricing matrix for this nationality
            $table->json('pricing_matrix')->nullable(); // {
            //   "adult": {"cost": 170, "commission_type": "percentage", "commission_amount": null},
            //   "child_young": {...},
            //   ...
            // }

            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->index(['seasonal_price_id', 'nationality_id']);
        });

        // === OPERATING SCHEDULES TABLE ===
        Schema::create('operating_schedules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->constrained('tourist_services')->onDelete('cascade');

            $table->string('day_name'); // Monday, Tuesday, etc. or "all_days"
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->text('special_notes')->nullable();

            $table->timestamps();
            $table->unique(['tourist_service_id', 'day_name']);
            $table->index('tourist_service_id');
        });

        // === SPECIAL HOURS TABLE (Holidays, seasonal changes) ===
        Schema::create('special_hours', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tourist_service_id')->constrained('tourist_services')->onDelete('cascade');

            $table->date('date');
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('type')->default('holiday'); // holiday, seasonal_change, temporary_closure
            $table->text('description')->nullable();
            $table->boolean('is_closed')->default(false);

            $table->timestamps();
            $table->index(['tourist_service_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_hours');
        Schema::dropIfExists('operating_schedules');
        Schema::dropIfExists('custom_nationalities');
        Schema::dropIfExists('subregion_pricing');
        Schema::dropIfExists('tourist_service_media');
        Schema::dropIfExists('tourist_service_modules');
        Schema::dropIfExists('commission_configurations');
        Schema::dropIfExists('tax_configurations');
        Schema::dropIfExists('seasonal_prices');
    }
};
