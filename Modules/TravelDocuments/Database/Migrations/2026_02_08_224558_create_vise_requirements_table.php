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
        if (Schema::hasTable('visa_requirements')) {
            return;
        }
        Schema::create('visa_requirements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Relationships
            $table->foreignId('nationality_id')->nullable();
            $table->foreignId('destination_country_id')->nullable();
            $table->foreignId('landcrossing_id')->nullable();

            // Visa Type & Category
            $table->enum('visa_type', ['none_required', 'on_arrival', 'e_visa', 'embassy_required', 'transit', 'restricted'])->default('on_arrival');

            $table->enum('visa_category', ['tourist', 'business', 'medical', 'student', 'work', 'transit'])->default('tourist');

            // Restrictions
            $table->boolean('is_restricted')->default(false);
            $table->boolean('can_issue_at_port')->default(true);

            // Duration & Validity
            $table->integer('max_stay_days')->nullable();
            $table->integer('visa_validity_days')->nullable();

            // Fees
            $table->decimal('visa_fee', 10, 2)->nullable();
            $table->foreignId('visa_fee_currency_id')->nullable();
            $table->decimal('departure_tax', 10, 2)->nullable();
            $table->foreignId('departure_tax_currency_id')->nullable();

            // Processing
            $table->integer('processing_time_days')->nullable();

            // Group Visa
            $table->integer('group_min_size')->nullable();
            $table->integer('group_min_nights')->nullable();
            $table->integer('group_processing_days')->nullable();

            // URLs
            $table->string('application_url', 500)->nullable();
            $table->string('official_source_url', 500)->nullable();

            // Validity Period
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();
            $table->timestamp('last_verified_at')->nullable();

            // Administrative
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['nationality_id', 'destination_country_id']);
            $table->index(['visa_type']);
            $table->index(['is_active']);
            $table->index(['crossing_port_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vise_requirements');
    }
};
