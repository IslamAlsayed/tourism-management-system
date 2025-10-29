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
        Schema::create('star_rating', function (Blueprint $table) {
            $table->id();
            $table->string('star_rating')->default(3); // 1, 2, 3, 4, 5
            $table->unsignedBigInteger('foreign_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('star_rating');
    }
};