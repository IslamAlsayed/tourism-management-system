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
        Schema::table('currencies', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_ar');
            $table->decimal('exchange_rate', 15, 6)->nullable()->after('symbol');
            $table->integer('decimal_places')->default(2)->after('exchange_rate');
            $table->boolean('is_major_currency')->default(false)->after('is_active');
            $table->boolean('is_base_currency')->default(false)->after('is_major_currency');
            $table->integer('sort_order')->default(0)->after('is_base_currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn([
                'name_ar',
                'name_en',
                'exchange_rate',
                'decimal_places',
                'is_major_currency',
                'is_base_currency',
                'sort_order'
            ]);
        });
    }
};
