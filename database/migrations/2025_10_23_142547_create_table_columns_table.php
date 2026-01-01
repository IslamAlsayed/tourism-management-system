<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('table_columns', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('model_class'); // e.g., 'App\Models\User'
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