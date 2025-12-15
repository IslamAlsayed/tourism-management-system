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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('client_code')->unique()->nullable();

            // Location information
            $table->foreignId('timezone_id')->nullable()->constrained('timezones')->onDelete('set null');
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('nationality_id')->nullable()->constrained('nationalities')->onDelete('set null');

            $table->string('currency', 3)->nullable();

            // Personal name information
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            // Personal details
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();

            // Passport information
            $table->string('passport_number')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();

            // Email addresses
            $table->string('personal_email')->nullable();
            $table->string('email_primary')->nullable();
            $table->string('work_email')->nullable();
            $table->string('secondary_email')->nullable();

            // Phone numbers
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('work_phone_ext')->nullable();
            $table->string('fax_number')->nullable();

            // Company/Business information
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('sector')->nullable();
            $table->string('department')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_registration_number')->nullable();
            $table->string('tax_id')->nullable();

            // Address information
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('street_address')->nullable();
            $table->text('address_line_2')->nullable();

            // Online presence
            $table->string('website_url')->nullable();
            $table->string('linkedin_url')->nullable();

            // Status and preferences
            $table->enum('client_status', ['active', 'inactive', 'pending', 'blacklisted'])->default('active');
            $table->string('whatsapp')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();

            // Tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index('email_primary');
            $table->index('personal_email');
            $table->index('passport_number');
            $table->index('client_status');
            $table->index(['region_id', 'subregion_id', 'country_id', 'state_id', 'city_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};