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
        Schema::create('rate_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rate_id')->nullable();
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->decimal('price', 10, 2)->default(0)->nullable();
            $table->string('price_type')->default('double_room')->nullable(); // double_room, single_room_supp, triple_room, third_person
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates_details');
    }
};