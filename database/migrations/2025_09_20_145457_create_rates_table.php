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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');
            // $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->unsignedBigInteger('accommodation_id')->nullable();
            // $table->foreignId('season_id')->nullable()->constrained('seasons')->onDelete('cascade');
            $table->unsignedBigInteger('season_id')->nullable();
            // $table->foreignId('room_type_id')->nullable()->constrained('room_types')->onDelete('cascade'); // للفنادق فقط
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};