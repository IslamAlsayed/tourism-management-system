<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeoAndTypeToHotelsTable extends Migration
{
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            if (!Schema::hasColumn('hotels', 'accommodation_type')) {
                $table->string('accommodation_type')->nullable()->after('id')->comment('hotel, camp, chalet, resort, etc.');
            }
            if (!Schema::hasColumn('hotels', 'region_id')) {
                $table->unsignedBigInteger('region_id')->nullable()->after('accommodation_type');
                $table->foreign('region_id')->references('id')->on('regions')->nullOnDelete();
            }
            if (!Schema::hasColumn('hotels', 'subregion_id')) {
                $table->unsignedBigInteger('subregion_id')->nullable()->after('region_id');
                $table->foreign('subregion_id')->references('id')->on('subregions')->nullOnDelete();
            }
            if (!Schema::hasColumn('hotels', 'city_id')) {
                $table->unsignedBigInteger('city_id')->nullable()->after('subregion_id');
                $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            if (Schema::hasColumn('hotels', 'accommodation_type')) {
                $table->dropColumn('accommodation_type');
            }
            if (Schema::hasColumn('hotels', 'region_id')) {
                $table->dropForeign(['region_id']);
                $table->dropColumn('region_id');
            }
            if (Schema::hasColumn('hotels', 'subregion_id')) {
                $table->dropForeign(['subregion_id']);
                $table->dropColumn('subregion_id');
            }
            if (Schema::hasColumn('hotels', 'city_id')) {
                $table->dropForeign(['city_id']);
                $table->dropColumn('city_id');
            }
        });
    }
}
