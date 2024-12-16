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
            $table->id(); // Auto-incrementing ID
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('instructor_id');
            $table->string('category')->nullable();
            $table->integer('duration')->nullable(); // Assuming duration is in minutes
            $table->string('level')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamps();
 
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
