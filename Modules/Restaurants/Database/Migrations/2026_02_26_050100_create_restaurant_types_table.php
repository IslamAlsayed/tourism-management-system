<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('restaurant_types')) {
            return;
        }
        Schema::create('restaurant_types', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('uuid');
            $table->index('name');
            $table->index('name_ar');
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_types');
    }
};
