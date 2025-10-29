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
        Schema::create('rate_nationalities', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('rate_id')->constrained('rates')->onDelete('cascade');
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->unsignedBigInteger('rate_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_nationalities');
    }
};