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
        Schema::table('course_user', function (Blueprint $table) {
            $table->foreign(['enrolled_by'], null)->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['student_id'], null)->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['course_id'], null)->references(['id'])->on('courses')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropForeign();
            $table->dropForeign();
            $table->dropForeign();
        });
    }
};