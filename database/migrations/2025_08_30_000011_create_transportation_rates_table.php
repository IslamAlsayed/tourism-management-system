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
            $table->decimal('price_per_day', 10, 2);
            $table->foreignId('company_id')->constrained('transportation_companies')->onDelete('cascade');
            $table->foreignId('bus_type_id')->constrained('bus_types')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('transportation_routes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportation_rates');
    }
}