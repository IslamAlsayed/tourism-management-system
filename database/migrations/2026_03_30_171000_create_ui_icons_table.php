<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ui_icons', function (Blueprint $table) {
            $table->id();
            $table->string('field_key')->unique();
            $table->string('icon_class');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ui_icons');
    }
};
