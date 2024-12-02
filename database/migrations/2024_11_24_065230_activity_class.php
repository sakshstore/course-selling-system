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
        Schema::dropIfExists('activity_logs');
        
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('details')->nullable();
            $table->string('ip_address')->nullable(); // Add IP address field
            $table->string('media_device')->nullable(); // Add media device field
            $table->string('message')->nullable(); // Add message field
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
