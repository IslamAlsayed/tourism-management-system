<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('wiki_data_id')->nullable();
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};