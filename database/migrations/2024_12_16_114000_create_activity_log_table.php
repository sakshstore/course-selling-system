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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('action');
            $table->text('details')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('media_device')->nullable();
            $table->string('message')->nullable();
            $table->timestamps();

// Adding foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');

        });}

/**
 * Reverse the migrations.
 */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('activity_logs');
    }
};
