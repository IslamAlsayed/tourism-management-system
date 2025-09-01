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
            $table->unsignedBigInteger('accommodation_id');
            $table->string('name')->nullable();
            $table->string('hotel_chain')->nullable();
            $table->string('sales_man')->nullable();
            $table->string('sales_phone')->nullable();
            $table->string('sales_mail')->nullable();
            $table->string('resv_man')->nullable();
            $table->string('resv_phone')->nullable();
            $table->string('resvr_mail')->nullable();
            $table->string('accounting_person')->nullable();
            $table->string('acc_mail')->nullable();
            $table->string('acc_phone')->nullable();
            $table->timestamps();

            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
}