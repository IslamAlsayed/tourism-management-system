<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('name_ar');
            $table->string('symbol');
            $table->decimal('exchange_rate', 15, 8); // يمكن تحديد دقة أعلى للعملات
            $table->integer('decimal_places');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_major_currency')->default(false);
            $table->boolean('is_base_currency')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};