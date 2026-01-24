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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();

            // Foreign Keys
            $table->foreignId('type_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->foreignId('region_id')->nullable();
            $table->foreignId('subregion_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();

            // Basic info
            $table->string('name')->nullable(); // e.g., Hilton Cairo, Bedouin Camp, other
            $table->string('name_ar')->nullable(); // e.g., هيلتون القاهرة، مخيم بدوي، أخرى
            $table->string('classification')->nullable(); // تصنيف الفندق
            $table->unsignedTinyInteger('stars')->nullable();

            // Contact info
            $table->string('general_mobile')->nullable();
            $table->string('general_email')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_ext')->nullable();
            $table->string('fax')->nullable();

            // Contact person
            $table->string('contact_person')->nullable();
            $table->string('contact_position')->nullable();
            $table->string('contact_mobile')->nullable();
            $table->string('contact_email')->nullable();

            $table->string('street')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // Contract
            $table->string('contract_file_path')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
