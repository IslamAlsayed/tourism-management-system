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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->longText('description')->nullable();

            // Contacts
            $table->string('created_by')->nullable();
            $table->string('sales_man')->nullable();
            $table->string('sales_phone')->nullable();
            $table->string('sales_mail')->nullable();
            $table->string('reservation_man')->nullable();
            $table->string('reservation_phone')->nullable();
            $table->string('reservation_mail')->nullable();
            $table->string('accounting_person')->nullable();
            $table->string('accounting_mail')->nullable();
            $table->string('accounting_phone')->nullable();

            // Location
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('subregion_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};