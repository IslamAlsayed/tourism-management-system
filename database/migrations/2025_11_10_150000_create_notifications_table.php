<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->uuid('uuid')->unique();
            $table->foreignId('performer_id')->nullable(); // من قام بالفعل
            $table->foreignId('target_user_id')->nullable(); // من يستلم الإشعار
            $table->string('type')->nullable()->default('success'); // booking, payment, trip, system, ...
            $table->string('notification_type')->default('system'); // system, push, custom, ...
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable(); // Additional data if needed
            $table->boolean('is_global')->default(false);
            $table->timestamps();

            $table->index(['performer_id', 'target_user_id', 'is_read']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.ص
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
