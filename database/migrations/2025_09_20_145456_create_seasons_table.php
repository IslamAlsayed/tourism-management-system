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
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('season_from')->nullable();
            $table->date('season_to')->nullable();
            $table->boolean('is_special')->nullable()->default(false);
            $table->string('special_type')->nullable(); // peak, weekend, event..
            // $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->unsignedBigInteger('accommodation_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};