<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNationalitiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('nationalities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar');
            $table->boolean('is_active')->default(true);
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nationalities');
    }
}