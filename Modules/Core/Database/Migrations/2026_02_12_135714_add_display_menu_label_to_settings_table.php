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
        if (Schema::hasColumn('settings', 'app_display_menu_labels')) {
            return;
        }
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('app_display_menu_labels')->default(true)->after('app_paginate_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('app_display_menu_labels');
        });
    }
};
