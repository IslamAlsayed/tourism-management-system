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
        Schema::create('automation_webhooks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('event_type')->nullable(); // e.g. 'order.created', '*'
            $table->boolean('is_active')->default(true);
            $table->string('secret_token')->nullable();
            $table->json('headers')->nullable();
            $table->timestamps();
        });

        Schema::create('automation_webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('webhook_id');
            $table->json('payload');
            $table->integer('response_status')->nullable();
            $table->text('response_body')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();

            $table->foreign('webhook_id')->references('id')->on('automation_webhooks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('automation_webhook_logs');
        Schema::dropIfExists('automation_webhooks');
    }
};
