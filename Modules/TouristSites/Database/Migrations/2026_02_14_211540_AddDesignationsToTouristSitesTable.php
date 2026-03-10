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
        Schema::table('tourist_sites', function (Blueprint $table) {
            $table->boolean('iucn_green_list')->default(false)->after('unesco_site');
            $table->boolean('gstc_certified')->default(false)->after('iucn_green_list');
            $table->boolean('blue_flag')->default(false)->after('gstc_certified');
            $table->boolean('green_destinations')->default(false)->after('blue_flag');
            $table->boolean('earthcheck_certified')->default(false)->after('green_destinations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tourist_sites', function (Blueprint $table) {
            $table->dropColumn([
                'iucn_green_list',
                'gstc_certified',
                'blue_flag',
                'green_destinations',
                'earthcheck_certified',
            ]);
        });
    }
};
