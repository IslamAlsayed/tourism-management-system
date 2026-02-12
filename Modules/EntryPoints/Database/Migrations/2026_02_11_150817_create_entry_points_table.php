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
        if (Schema::hasTable('entry_points')) {
            return;
        }
        Schema::create('entry_points', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            // Location relationships
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();

            // Basic information
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('type');
            $table->string('code')->unique()->nullable();

            // Geographic coordinates
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('address')->nullable();

            // Operating information
            $table->json('operating_days')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->boolean('is_24_7')->default(false);
            $table->boolean('is_commercial')->default(false);
            $table->boolean('is_passenger')->default(true);
            $table->boolean('is_international')->default(false);

            // Visa and immigration policies
            $table->boolean('allows_visa_on_arrival')->default(false);
            $table->json('nationality_policy')->nullable(); // Policies per nationality
            $table->decimal('departure_tax', 8, 2)->nullable();
            $table->foreignId('departure_tax_currency_id')->nullable();

            // Contact information
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            // Display and classification
            $table->integer('sort_order')->default(0);
            $table->boolean('is_major')->default(false);

            // Visa requirements
            $table->boolean('visa_required')->default(false);
            $table->decimal('visa_fee', 8, 2)->nullable();
            $table->foreignId('visa_fee_currency_id')->nullable();
            $table->integer('visa_duration')->nullable(); // Days
            $table->text('visa_conditions')->nullable();
            $table->string('visa_application_url')->nullable();
            $table->string('visa_policy_source')->nullable();
            $table->timestamp('visa_last_update')->nullable();

            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry_points');
    }
};
