<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
/**
 * Run the migrations.
 */
    public function up(): void
    {
        Schema::create('study_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('course_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->date('upload_date')->nullable();
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->string('tags')->nullable();
            $table->integer('order')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();
        });
    }

/**
 * Reverse the migrations.
 */
    public function down(): void
    {
        Schema::dropIfExists('study_materials');
    }
};
