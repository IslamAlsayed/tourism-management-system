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
            $table->json('nationality_prices')->nullable()->after('entry_fee_resident_child');
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
            $table->dropColumn('nationality_prices');
        });
    }
};
