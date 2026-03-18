<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('system_languages', function (Blueprint $table) {
            if (!Schema::hasColumn('system_languages', 'name_ar')) {
                $table->string('name_ar')->nullable()->after('name');
            }
            if (!Schema::hasColumn('system_languages', 'native')) {
                $table->string('native')->nullable()->after('name_ar');
            }
            if (!Schema::hasColumn('system_languages', 'dir')) {
                $table->string('dir')->default('ltr')->after('native');
            }
            if (!Schema::hasColumn('system_languages', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('photo');
            }
            if (!Schema::hasColumn('system_languages', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_active');
            }
        });
    }

    public function down()
    {
        Schema::table('system_languages', function (Blueprint $table) {
            $columns = ['name_ar', 'native', 'dir', 'is_active', 'sort_order'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('system_languages', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
