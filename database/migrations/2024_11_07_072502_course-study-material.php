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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->string('category')->nullable();
            $table->integer('duration')->nullable(); // Duration in hours or weeks
            $table->string('level')->nullable(); // e.g., beginner, intermediate, advanced
            $table->decimal('price', 8, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
        });

        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('type')->nullable(); // e.g., PDF, video, audio
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->date('upload_date')->nullable();
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->string('tags')->nullable();
            $table->integer('order')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('duration')->nullable(); // Duration in minutes, if applicable
            $table->integer('size')->nullable(); // Size in KB or MB
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_materials');
        Schema::dropIfExists('courses');
    }
};
