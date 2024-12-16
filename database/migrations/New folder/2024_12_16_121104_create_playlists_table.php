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
{  Schema::dropIfExists('playlists');
Schema::create('playlists', function (Blueprint $table) {
$table->id(); // Auto-incrementing ID
$table->string('name');
$table->unsignedBigInteger('course_id');
$table->unsignedBigInteger('user_id');
$table->timestamps();

// Adding foreign key constraints
$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('no action');
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
});

// Pivot table for playlist and study materials relationship
Schema::create('playlist_study_material', function (Blueprint $table) {
$table->id(); // Auto-incrementing ID
$table->unsignedBigInteger('playlist_id');
$table->unsignedBigInteger('study_material_id');
$table->timestamps();

// Adding foreign key constraints
$table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade')->onUpdate('no action');
$table->foreign('study_material_id')->references('id')->on('study_materials')->onDelete('cascade')->onUpdate('no action');
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::table('playlist_study_material', function (Blueprint $table) {
$table->dropForeign(['playlist_id']);
$table->dropForeign(['study_material_id']);
});

Schema::dropIfExists('playlist_study_material');

Schema::table('playlists', function (Blueprint $table) {
$table->dropForeign(['course_id']);
$table->dropForeign(['user_id']);
});

Schema::dropIfExists('playlists');
}
};