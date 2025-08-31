<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusTypesTable extends Migration
{
    public function up(): void
    {
        Schema::create('bus_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('name');
            $table->integer('seats');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('transportation_companies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_types');
    }
}