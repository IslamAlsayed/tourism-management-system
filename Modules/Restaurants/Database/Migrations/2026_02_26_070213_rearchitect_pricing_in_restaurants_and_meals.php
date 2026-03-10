<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // For restaurants table
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['price_adult', 'price_child_6_11', 'price_child_under_6', 'pricing_type']);
            
            $table->decimal('fit_price_adult', 10, 2)->nullable()->after('subregion_id');
            $table->decimal('fit_price_child_6_11', 10, 2)->nullable()->after('fit_price_adult');
            $table->decimal('fit_price_child_under_6', 10, 2)->nullable()->after('fit_price_child_6_11');
            
            $table->decimal('group_price_adult', 10, 2)->nullable()->after('fit_price_child_under_6');
            $table->decimal('group_price_child_6_11', 10, 2)->nullable()->after('group_price_adult');
            $table->decimal('group_price_child_under_6', 10, 2)->nullable()->after('group_price_child_6_11');
        });

        // For restaurant_meals table
        Schema::table('restaurant_meals', function (Blueprint $table) {
            $table->dropColumn(['price_adult', 'price_child_6_11', 'price_child_under_6', 'pricing_type']);
            
            $table->decimal('fit_price_adult', 10, 2)->nullable()->after('price');
            $table->decimal('fit_price_child_6_11', 10, 2)->nullable()->after('fit_price_adult');
            $table->decimal('fit_price_child_under_6', 10, 2)->nullable()->after('fit_price_child_6_11');
            
            $table->decimal('group_price_adult', 10, 2)->nullable()->after('fit_price_child_under_6');
            $table->decimal('group_price_child_6_11', 10, 2)->nullable()->after('group_price_adult');
            $table->decimal('group_price_child_under_6', 10, 2)->nullable()->after('group_price_child_6_11');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // For restaurants table
        Schema::table('restaurants', function (Blueprint $table) {
            $table->decimal('price_adult', 10, 2)->nullable();
            $table->decimal('price_child_6_11', 10, 2)->nullable();
            $table->decimal('price_child_under_6', 10, 2)->nullable();
            $table->enum('pricing_type', ['adult_only', 'children_only', 'both'])->nullable();
            
            $table->dropColumn([
                'fit_price_adult', 
                'fit_price_child_6_11', 
                'fit_price_child_under_6',
                'group_price_adult',
                'group_price_child_6_11',
                'group_price_child_under_6'
            ]);
        });

        // For restaurant_meals table
        Schema::table('restaurant_meals', function (Blueprint $table) {
            $table->decimal('price_adult', 10, 2)->nullable();
            $table->decimal('price_child_6_11', 10, 2)->nullable();
            $table->decimal('price_child_under_6', 10, 2)->nullable();
            $table->enum('pricing_type', ['adult_only', 'children_only', 'both'])->nullable();
            
            $table->dropColumn([
                'fit_price_adult', 
                'fit_price_child_6_11', 
                'fit_price_child_under_6',
                'group_price_adult',
                'group_price_child_6_11',
                'group_price_child_under_6'
            ]);
        });
    }
};
