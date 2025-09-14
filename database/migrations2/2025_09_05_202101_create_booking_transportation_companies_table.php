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
        Schema::create('booking_transportation_companies', function (Blueprint $table) {
            $table->id();
            $table->integer('day')->default(1);
            $table->decimal('price_per_day', 12, 2)->default(0);
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('transportation_companies')->cascadeOnDelete();
            $table->foreignId('bus_type_id')->constrained('bus_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_transportation_companies');
    }
};