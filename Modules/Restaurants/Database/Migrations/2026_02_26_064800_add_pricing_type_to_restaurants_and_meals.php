<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add pricing_type and min_group_size to restaurants
        Schema::table('restaurants', function (Blueprint $table) {
            $table->enum('pricing_type', ['group', 'fit', 'both'])->default('group')->after('specialty');
            $table->integer('min_group_size')->nullable()->after('pricing_type');
        });

        // Add pricing_type and min_group_size to restaurant_meals
        Schema::table('restaurant_meals', function (Blueprint $table) {
            $table->enum('pricing_type', ['group', 'fit', 'both'])->default('group')->after('name_ar');
            $table->integer('min_group_size')->nullable()->after('pricing_type');
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['pricing_type', 'min_group_size']);
        });
        Schema::table('restaurant_meals', function (Blueprint $table) {
            $table->dropColumn(['pricing_type', 'min_group_size']);
        });
    }
};
