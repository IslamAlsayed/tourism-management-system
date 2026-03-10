<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            if (!Schema::hasColumn('countries', 'emoji')) {
                $table->string('emoji', 10)->nullable()->after('photo');
            }
            if (!Schema::hasColumn('countries', 'emojiU')) {
                $table->string('emojiU', 50)->nullable()->after('emoji');
            }
        });
    }

    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn(['emoji', 'emojiU']);
        });
    }
};
