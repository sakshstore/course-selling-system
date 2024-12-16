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
    Schema::create('login_histories', function (Blueprint $table) {
    $table->id(); // Auto-incrementing ID
    $table->unsignedBigInteger('user_id');
    $table->string('ip_address')->nullable();
    $table->string('user_agent')->nullable();
    $table->string('location')->nullable();
    $table->string('device')->nullable();
    $table->string('session_id')->nullable();
    $table->string('login_method')->nullable();
    $table->string('login_status')->nullable();
    $table->timestamps();
    
    // Adding foreign key constraint
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
    });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};
