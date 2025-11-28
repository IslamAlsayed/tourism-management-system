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
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Deprecated, use performer_id and target_user_id
            $table->unsignedBigInteger('performer_id')->nullable(); // من قام بالفعل
            $table->unsignedBigInteger('target_user_id')->nullable(); // من يستلم الإشعار
            $table->string('type')->nullable()->default('success'); // booking, payment, trip, system, ...
            $table->string('notification_type')->default('system'); // system, push, custom, ...
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable(); // Additional data if needed
            $table->unsignedBigInteger('recipient_user_id')->nullable(); // legacy, use target_user_id
            $table->boolean('is_global')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('performer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('target_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('recipient_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['performer_id', 'target_user_id', 'is_read']);
            $table->index(['recipient_user_id', 'is_global']);
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