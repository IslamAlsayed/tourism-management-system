<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeoToRestaurantsTable extends Migration
{
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurants', 'region_id')) {
                $table->unsignedBigInteger('region_id')->nullable()->after('id');
                $table->foreign('region_id')->references('id')->on('regions')->nullOnDelete();
            }
            if (!Schema::hasColumn('restaurants', 'subregion_id')) {
                $table->unsignedBigInteger('subregion_id')->nullable()->after('region_id');
                $table->foreign('subregion_id')->references('id')->on('subregions')->nullOnDelete();
            }
            if (!Schema::hasColumn('restaurants', 'city_id')) {
                $table->unsignedBigInteger('city_id')->nullable()->after('subregion_id');
                $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (Schema::hasColumn('restaurants', 'region_id')) {
                $table->dropForeign(['region_id']);
                $table->dropColumn('region_id');
            }
            if (Schema::hasColumn('restaurants', 'subregion_id')) {
                $table->dropForeign(['subregion_id']);
                $table->dropColumn('subregion_id');
            }
            if (Schema::hasColumn('restaurants', 'city_id')) {
                $table->dropForeign(['city_id']);
                $table->dropColumn('city_id');
            }
        });
    }
}