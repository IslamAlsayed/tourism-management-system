<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('continent');
            $table->string('country');
            $table->string('timezone');
            $table->string('country_code');
            $table->string('state');
            $table->string('city');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('gf_name')->nullable();
            $table->string('last_name');
            $table->string('gender');
            $table->string('nationality');
            $table->date('birth_date');
            $table->string('passport_number')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('work_phone_ext')->nullable();
            $table->string('email_primary')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('work_email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('website_url')->nullable();
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('sector')->nullable();
            $table->string('department')->nullable();
            $table->string('business_type')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('street_address')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('business_registration_number')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->text('notes')->nullable();
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