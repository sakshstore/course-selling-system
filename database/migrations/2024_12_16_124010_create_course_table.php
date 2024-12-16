<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('instructor_id');
            $table->string('category')->nullable();
            $table->integer('duration')->nullable();
            $table->string('level')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('path')->nullable();
            $table->string('url');
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('type');
            $table->unsignedBigInteger('uploaded_by');
            $table->date('upload_date')->nullable();
            $table->string('visibility')->nullable();
            $table->string('tags')->nullable();
            $table->integer('order')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();
        });

        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('playlist_study_material', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedBigInteger('study_material_id');
            $table->timestamps();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('study_materials', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('playlist_study_material', function (Blueprint $table) {
            $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('study_material_id')->references('id')->on('study_materials')->onDelete('cascade')->onUpdate('no action');
        });

    }

    public function down(): void
    {
    // Drop foreign key constraints
    Schema::table('playlist_study_material', function (Blueprint $table) {
    $table->dropForeign(['playlist_id']);
    $table->dropForeign(['study_material_id']);
    });
    
    Schema::table('playlists', function (Blueprint $table) {
    $table->dropForeign(['course_id']);
    $table->dropForeign(['user_id']);
    });
    
    Schema::table('study_materials', function (Blueprint $table) {
    $table->dropForeign(['course_id']);
    $table->dropForeign(['uploaded_by']);
    });
    
    Schema::table('videos', function (Blueprint $table) {
    $table->dropForeign(['course_id']);
    $table->dropForeign(['playlist_id']);
    $table->dropForeign(['user_id']);
    });
    
    Schema::table('courses', function (Blueprint $table) {
    $table->dropForeign(['instructor_id']);
    });
    
    // Drop the tables
    Schema::dropIfExists('playlist_study_material');
    Schema::dropIfExists('playlists');
    Schema::dropIfExists('study_materials');
    Schema::dropIfExists('videos');
    Schema::dropIfExists('courses');
    }
};
