<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('tourist_sites', 'nationality_prices')) {
            Schema::table('tourist_sites', function (Blueprint $table) {
                $table->dropColumn('nationality_prices');
            });
        }
    }

    public function down()
    {
        if (!Schema::hasColumn('tourist_sites', 'nationality_prices')) {
            Schema::table('tourist_sites', function (Blueprint $table) {
                $table->json('nationality_prices')->nullable()->after('entry_fee_resident_child');
            });
        }
    }
};
