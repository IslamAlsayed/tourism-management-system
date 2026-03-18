<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('system_languages', function (Blueprint $table) {
            if (!Schema::hasColumn('system_languages', 'is_default')) {
                $table->boolean('is_default')->default(false)->after('is_active');
            }
        });

        // Set English as default if no default exists
        $hasDefault = \DB::table('system_languages')->where('is_default', true)->exists();
        if (!$hasDefault) {
            \DB::table('system_languages')->where('code', 'en')->update(['is_default' => true]);
        }
    }

    public function down()
    {
        Schema::table('system_languages', function (Blueprint $table) {
            if (Schema::hasColumn('system_languages', 'is_default')) {
                $table->dropColumn('is_default');
            }
        });
    }
};
