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
        Schema::create('crossing_ports', function (Blueprint $table) {
            $table->id();

            // Location relationships
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            // Basic information
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->enum('type', ['land_crossing', 'international_airport', 'domestic_airport', 'seaport', 'river_port', 'border_crossing']);
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();

            // Geographic coordinates
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Operating information
            $table->string('operating_hours')->nullable();
            $table->string('operating_hours_ar')->nullable();
            $table->boolean('is_24_7')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_commercial')->default(false);
            $table->boolean('is_passenger')->default(true);
            $table->boolean('is_international')->default(false);

            // Visa and immigration policies
            $table->boolean('allows_visa_on_arrival')->default(false);
            $table->json('nationality_policy')->nullable(); // Policies per nationality
            $table->decimal('departure_tax', 8, 2)->nullable();
            $table->string('departure_tax_currency', 3)->nullable();

            // Contact information
            $table->string('contact_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Display and classification
            $table->integer('sort_order')->default(0);
            $table->boolean('is_major')->default(false);

            // Visa requirements
            $table->boolean('visa_required')->default(false);
            $table->decimal('visa_fee', 8, 2)->nullable();
            $table->string('visa_fee_currency', 3)->nullable();
            $table->integer('visa_duration')->nullable(); // Days
            $table->text('visa_conditions')->nullable();
            $table->string('visa_application_url')->nullable();
            $table->string('visa_policy_source')->nullable();
            $table->timestamp('visa_last_update')->nullable();

            // Additional notes
            $table->text('note')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index(['type']);
            $table->index(['is_active']);
            $table->index(['is_international']);
            $table->index(['country_id', 'state_id', 'city_id']);
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crossing_ports');
    }
};
