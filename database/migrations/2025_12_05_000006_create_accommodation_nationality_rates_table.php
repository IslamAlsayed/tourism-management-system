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
        Schema::create('accommodation_nationality_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nationality_id')->constrained()->cascadeOnDelete();

            // يمكن تحديد أسعار خاصة حسب الجنسية
            $table->decimal('price_modifier', 10, 2)->nullable(); // تعديل على السعر (+ أو -)
            $table->decimal('percentage_discount', 5, 2)->nullable(); // نسبة خصم
            $table->string('currency', 3)->default('USD');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['accommodation_id', 'season_id', 'nationality_id'], 'acc_season_nat_unique');
            $table->index(['accommodation_id', 'nationality_id'], 'acc_nat_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_nationality_rates');
    }
};