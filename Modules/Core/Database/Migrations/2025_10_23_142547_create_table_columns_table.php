<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('table_columns')) {
            return;
        }
        Schema::create('table_columns', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable();
            $table->string('model_class'); // e.g., 'Modules\Core\Entities\User'
            $table->json('columns'); // Array of column names in order
            $table->timestamps();

            $table->unique(['user_id', 'model_class']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('table_columns');
    }
};
