<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('created_by');
            $table->string('sales_man')->nullable();
            $table->string('sales_phone')->nullable();
            $table->string('sales_mail')->nullable();
            $table->string('reservation_man')->nullable();
            $table->string('reservation_phone')->nullable();
            $table->string('reservation_mail')->nullable();
            $table->string('accounting_person')->nullable();
            $table->string('accounting_mail')->nullable();
            $table->string('accounting_phone')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->foreignId('subregion_id')->constrained('subregions')->onDelete('cascade');
            $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
}