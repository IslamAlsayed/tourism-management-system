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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('currency_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('hotel_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('hotel_room_type_id')->nullable()->constrained('hotel_room_types')->onDelete('set null');
            $table->foreignId('hotel_season_id')->nullable()->constrained('hotel_seasons')->onDelete('set null');
            $table->timestamps();
        });

        // Pivot tables للـ relations
        Schema::create('booking_transportation_company', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('transportation_company_id')->constrained()->onDelete('cascade');
        });

        Schema::create('booking_other_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('other_service_id')->constrained()->onDelete('cascade');
        });

        Schema::create('booking_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};