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

            // ownership + lifecycle
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'submitted', 'cancelled'])->default('draft');

            // customer info (step 1)
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality')->nullable();
            $table->unsignedInteger('adults')->default(1);
            $table->unsignedInteger('children')->default(0);
            $table->unsignedInteger('infants')->default(0);
            $table->date('arrival_date')->nullable();
            $table->date('departure_date')->nullable();

            // core references (optional if applicable in quote)
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('hotel_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('hotel_room_type_id')->nullable()->constrained('hotel_room_types')->nullOnDelete();
            $table->foreignId('hotel_season_id')->nullable()->constrained('hotel_seasons')->nullOnDelete();

            // pricing snapshot (step 4)
            $table->decimal('subtotal_hotels', 12, 2)->default(0);
            $table->decimal('subtotal_transport', 12, 2)->default(0);
            $table->decimal('subtotal_services', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->timestamps();
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