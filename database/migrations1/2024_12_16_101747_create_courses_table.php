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
Schema::create('courses', function (Blueprint $table) {
$table->increments('id');
$table->string('title');
$table->text('description')->nullable();
$table->unsignedBigInteger('instructor_id');
$table->string('category')->nullable();
$table->integer('duration')->nullable();
$table->string('level')->nullable();
$table->decimal('price', 8, 2)->nullable();
$table->date('start_date')->nullable();
$table->date('end_date')->nullable();
$table->enum('status', ['draft', 'published', 'archived'])->default('draft');
$table->timestamps();
$table->string('thumbnail')->nullable();
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('courses');
}
};