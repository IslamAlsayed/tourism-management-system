<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationSupplementsTable extends Migration
{
    public function up(): void
    {
        Schema::create('accommodation_supplements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accommodation_id');
            $table->string('name');
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_per_person')->default(false);
            $table->boolean('is_mandatory')->default(false);
            $table->date('applicable_date')->nullable();
            $table->timestamps();

            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodation_supplements');
    }
}