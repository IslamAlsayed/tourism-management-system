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
        Schema::table('cruises', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('type');
            $table->unsignedBigInteger('region_id')->nullable()->index()->after('policies');
            $table->unsignedBigInteger('subregion_id')->nullable()->index()->after('region_id');
            $table->unsignedBigInteger('country_id')->nullable()->index()->after('subregion_id');
            $table->unsignedBigInteger('state_id')->nullable()->index()->after('country_id');
            $table->unsignedBigInteger('city_id')->nullable()->index()->after('state_id');
            $table->unsignedBigInteger('main_start_point_id')->nullable()->index()->after('city_id');
            $table->unsignedBigInteger('main_end_point_id')->nullable()->index()->after('main_start_point_id');
            $table->unsignedBigInteger('vessel_nationality_id')->nullable()->index()->comment('Country flag of the vessel')->after('main_end_point_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cruises', function (Blueprint $table) {
            $table->dropColumn([
                'photo',
                'region_id',
                'subregion_id',
                'country_id',
                'state_id',
                'city_id',
                'main_start_point_id',
                'main_end_point_id',
                'vessel_nationality_id'
            ]);
        });
    }
};
