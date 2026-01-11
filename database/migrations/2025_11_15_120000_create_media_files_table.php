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
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('file_name')->unique();
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable(); // image, document, video, etc.
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size')->nullable(); // in bytes
            $table->string('disk')->default('public');
            $table->string('collection_name')->nullable(); // users, accommodations, restaurants, etc.
            $table->string('model_type')->nullable(); // App\Models\User, App\Models\Accommodation, etc.
            $table->unsignedBigInteger('model_id')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('alt_text')->nullable();
            $table->text('description')->nullable();
            $table->string('title')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->nullable();
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['model_type', 'model_id']);
            $table->index('collection_name');
            $table->index('file_type');
            $table->index('is_active');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};