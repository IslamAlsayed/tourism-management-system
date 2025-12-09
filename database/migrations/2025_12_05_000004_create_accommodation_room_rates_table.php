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
        Schema::create('accommodation_room_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();

            // Prices
            $table->decimal('price_per_person_double', 10, 2)->nullable(); // سعر الشخص في غرفة مزدوجة
            $table->decimal('single_room_supplement', 10, 2)->nullable(); // إضافة غرفة فردية
            $table->decimal('triple_room_discount', 10, 2)->nullable(); // خصم غرفة ثلاثية
            $table->decimal('third_person_price', 10, 2)->nullable(); // سعر الشخص الثالث
            $table->decimal('extra_bed_price', 10, 2)->nullable(); // سعر سرير إضافي
            $table->decimal('sea_view_supplement', 10, 2)->nullable(); // إضافة إطلالة بحر
            $table->boolean('is_active')->default(true);

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['accommodation_id', 'season_id', 'room_id'], 'acc_season_room_unique');
            $table->index(['accommodation_id', 'season_id'], 'acc_season_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_room_rates');
    }
};