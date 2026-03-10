<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->foreignId('region_id')->nullable()->after('city_id');
            $table->foreignId('subregion_id')->nullable()->after('region_id');

            $table->index('region_id');
            $table->index('subregion_id');
        });
    }

    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropIndex(['region_id']);
            $table->dropIndex(['subregion_id']);
            $table->dropColumn(['region_id', 'subregion_id']);
        });
    }
};
