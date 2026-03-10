<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->decimal('price_adult', 10, 2)->nullable()->after('specialty');
            $table->decimal('price_child_6_11', 10, 2)->nullable()->after('price_adult');
            $table->decimal('price_child_under_6', 10, 2)->nullable()->after('price_child_6_11');
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['price_adult', 'price_child_6_11', 'price_child_under_6']);
        });
    }
};
