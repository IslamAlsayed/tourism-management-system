<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sidebar_menu_orders', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->string('menu_key')->unique(); // unique identifier for menu item
            $table->integer('order')->default(0); // sort order
            $table->string('parent_key')->nullable(); // parent menu key for nested items
            $table->integer('level')->default(0); // menu level (0=main, 1=sub, 2=sub-sub)
            $table->boolean('is_visible')->default(true); // visibility toggle
            $table->json('custom_data')->nullable(); // for storing custom configurations
            $table->timestamps();

            $table->index(['parent_key', 'order']);
            $table->index(['level', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidebar_menu_orders');
    }
};
