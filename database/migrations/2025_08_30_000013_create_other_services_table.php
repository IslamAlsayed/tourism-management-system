<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherServicesTable extends Migration
{
    public function up()
    {
        Schema::create('other_services', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->enum('price_type', ['Per Person', 'Per Group', 'Per Day'])->default('Per Person');
            $table->decimal('price', 12, 2);
            $table->foreignId('currency_id')->constrained('currencies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('other_services');
    }
}