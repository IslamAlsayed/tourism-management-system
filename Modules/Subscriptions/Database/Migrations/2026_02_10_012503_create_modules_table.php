<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Module unique identifier e.g. tour_guides');
            $table->string('name')->comment('Display name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable()->comment('FontAwesome icon class');
            $table->json('requires')->nullable()->comment('Required modules as dependencies');
            $table->boolean('is_core')->default(false)->comment('Core modules cannot be disabled');
            $table->boolean('is_available')->default(true)->comment('Module availability status');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_core', 'is_available']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
};
