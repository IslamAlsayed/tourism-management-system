<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelSupplementsTable extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_supplements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 12, 2);
            $table->boolean('is_per_person')->default(true);
            $table->boolean('is_mandatory')->default(false);
            $table->date('applicable_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_supplements');
    }
}