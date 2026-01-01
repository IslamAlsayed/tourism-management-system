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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('model_type')->nullable();
            // $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies')->onDelete('cascade');

            $table->string('name'); // e.g., Single, Double, Triple, Suite, Quad
            $table->string('name_ar')->nullable();
            $table->unsignedInteger('max_occupancy')->comment('Total max persons');
            $table->string('occupancy_details')->nullable()->comment('e.g. 2A+1C');

            // Prices
            $table->decimal('price_per_person_double', 10, 2)->nullable(); // سعر الشخص في غرفة مزدوجة
            $table->decimal('single_room_supplement', 10, 2)->nullable(); // إضافة غرفة فردية
            $table->decimal('triple_room_discount', 10, 2)->nullable(); // خصم غرفة ثلاثية
            $table->decimal('third_person_price', 10, 2)->nullable(); // سعر الشخص الثالث
            $table->decimal('extra_bed_price', 10, 2)->nullable(); // سعر سرير إضافي
            $table->decimal('sea_view_supplement', 10, 2)->nullable(); // إضافة إطلالة بحر

            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['name', 'name_ar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};