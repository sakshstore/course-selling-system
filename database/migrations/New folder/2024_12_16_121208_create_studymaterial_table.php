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
$table->id(); // Auto-incrementing ID
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
$table->integer('duration')->nullable(); // Assuming duration is in minutes
$table->integer('size')->nullable(); // Assuming size is in bytes
$table->timestamps();

// Adding foreign key constraints
$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('no action');
$table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::table('study_materials', function (Blueprint $table) {
$table->dropForeign(['course_id']);
$table->dropForeign(['uploaded_by']);
});

Schema::dropIfExists('study_materials');
}
};

