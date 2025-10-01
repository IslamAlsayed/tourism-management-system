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
        Schema::create('transportation_company_departments', function (Blueprint $table) {
            $table->id();
            $table->string('department')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone_01')->nullable();
            $table->string('phone_02')->nullable();
            $table->string('email_01')->nullable();
            $table->string('email_02')->nullable();
            $table->string('fax')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->foreignId('company_id')->nullable()->constrained('transportation_companies')->onDelete('SET NULL');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('SET NULL');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('SET NULL');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('SET NULL');
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('SET NULL');
            $table->foreignId('subregion_id')->nullable()->constrained('subregions')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_company_departments');
    }
};