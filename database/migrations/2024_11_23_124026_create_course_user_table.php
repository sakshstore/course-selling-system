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

        
        Schema::dropIfExists('course_user');


        Schema::create('course_user', function (Blueprint $table) {
       $table->id();
$table->foreignId('course_id')->constrained()->onDelete('cascade');
$table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Use student_id instead of user_id
$table->foreignId('enrolled_by')->constrained('users')->onDelete('cascade'); // Add this line
$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_user');
    }
};
