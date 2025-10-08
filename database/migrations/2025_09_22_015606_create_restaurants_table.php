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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('subregion_id')->nullable();
            $table->string('rating')->nullable()->default('3');
            $table->string('company_name_ar')->nullable();
            $table->string('specialty')->nullable();
            $table->string('phone_01')->nullable();
            $table->string('phone_02')->nullable();
            $table->string('fax')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email_01')->nullable();
            $table->string('email_02')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('street')->nullable();
            $table->string('mobile')->nullable();
            $table->string('website')->nullable();
            $table->string('photo')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('wheelchair_accessible')->default(true);
            $table->boolean('free_wifi')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('swimming_pool')->default(false);
            $table->boolean('gym')->default(false);
            $table->boolean('indoor')->default(false);
            $table->boolean('outdoor')->default(false);
            $table->boolean('spa')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};