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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies')->onDelete('cascade');

            $table->string('name'); // e.g., Breakfast, Lunch, Dinner, Full Board, Half Board
            $table->string('name_ar')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // سعر الوجبة
            $table->boolean('is_included')->default(false); // هل مشمولة في السعر الأساسي
            $table->boolean('is_supplement')->default(true); // هل هي إضافة أم مشمولة
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index(['accommodation_id', 'season_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};