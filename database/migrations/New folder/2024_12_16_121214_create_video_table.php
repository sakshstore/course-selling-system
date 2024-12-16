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
Schema::create('videos', function (Blueprint $table) {
$table->id(); // Auto-incrementing ID
$table->unsignedBigInteger('course_id');
$table->unsignedBigInteger('playlist_id');
$table->unsignedBigInteger('user_id');
$table->string('title');
$table->text('description')->nullable();
$table->string('path')->nullable();
$table->string('url');
$table->string('status')->nullable();
$table->timestamps();

// Adding foreign key constraints
$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('no action');
$table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade')->onUpdate('no action');
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::table('videos', function (Blueprint $table) {
$table->dropForeign(['course_id']);
$table->dropForeign(['playlist_id']);
$table->dropForeign(['user_id']);
});

Schema::dropIfExists('videos');
}
};
