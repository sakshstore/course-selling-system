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
$table->increments('id');
$table->unsignedBigInteger('user_id');
$table->unsignedBigInteger('course_id')->nullable();
$table->unsignedBigInteger('playlist_id')->nullable();
$table->string('title');
$table->text('description')->nullable();
$table->text('tags')->nullable();
$table->string('path');
$table->string('url');
$table->timestamps();
$table->text('status')->nullable();
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('videos');
}
};