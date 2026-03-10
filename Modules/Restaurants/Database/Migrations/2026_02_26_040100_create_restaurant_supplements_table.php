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
        if (Schema::hasTable('restaurant_supplements')) {
            return;
        }
        Schema::create('restaurant_supplements', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->foreignId('restaurant_id')->nullable()->constrained('restaurants')->nullOnDelete();

            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('price_type', ['per_person', 'per_room', 'per_night', 'one_time'])->nullable();
            $table->date('applicable_date')->nullable();
            $table->boolean('is_mandatory')->default(false);
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            $table->index(['name', 'name_ar']);
            $table->index('restaurant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_supplements');
    }
};
