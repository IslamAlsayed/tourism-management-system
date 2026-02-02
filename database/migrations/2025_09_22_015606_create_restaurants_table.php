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
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->foreignId('type_id')->nullable();
            $table->foreignId('timezone_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('cat')->nullable();
            $table->string('rating')->nullable()->default('3');
            $table->string('company_name')->nullable();
            $table->string('specialty')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email_01')->nullable();
            $table->string('email_02')->nullable();
            $table->string('phone_01')->nullable();
            $table->string('phone_02')->nullable();
            $table->string('fax')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('street')->nullable();
            $table->string('mobile')->nullable();
            $table->string('website')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('wheelchair_accessible')->nullable()->default(true);
            $table->boolean('free_wifi')->nullable()->default(false);
            $table->boolean('parking')->nullable()->default(false);
            $table->boolean('swimming_pool')->nullable()->default(false);
            $table->boolean('gym')->nullable()->default(false);
            $table->boolean('indoor')->nullable()->default(false);
            $table->boolean('outdoor')->nullable()->default(false);
            $table->boolean('spa')->nullable()->default(false);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('uuid');
            $table->index('name');
            $table->index('name_ar');
            $table->index('type_id');
            $table->index('timezone_id');
            $table->index('currency_id');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('city_id');
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
