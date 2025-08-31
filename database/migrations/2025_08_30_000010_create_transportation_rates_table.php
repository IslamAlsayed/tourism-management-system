<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationRatesTable extends Migration
{
    public function up(): void
    {
        Schema::create('transportation_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('bus_type_id');
            $table->string('route');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('transportation_companies')->onDelete('cascade');
            $table->foreign('bus_type_id')->references('id')->on('bus_types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportation_rates');
    }
}