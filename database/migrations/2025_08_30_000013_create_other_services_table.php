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
            $table->string('name');
            $table->string('name_ar');
            $table->enum('price_type', ['Per Person', 'Per Group', 'Per Day'])->default('Per Person');
            $table->decimal('price', 12, 2);
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('other_services');
    }
}