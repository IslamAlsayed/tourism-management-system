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
        Schema::table('modules', function (Blueprint $table) {
            $table->json('features')->nullable()->comment('Module features as JSON array')->after('requires');
            $table->decimal('price_monthly', 8, 2)->nullable()->comment('Monthly subscription price')->after('features');
            $table->decimal('price_yearly', 8, 2)->nullable()->comment('Yearly subscription price')->after('price_monthly');
            $table->integer('trial_days')->nullable()->default(0)->comment('Trial period in days')->after('price_yearly');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['features', 'price_monthly', 'price_yearly', 'trial_days']);
        });
    }
};
