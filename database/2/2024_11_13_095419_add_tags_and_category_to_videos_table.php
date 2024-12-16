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
          
        Schema::dropIfExists('videos');


        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to courses table
            $table->foreignId('playlist_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to playlists table
            $table->string('title');
            $table->text('description')->nullable();   
            
            $table->text('tags')->nullable();
            $table->string('path'); // Path to the video file
            $table->string('url'); // URL to access the video
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            //
        });
    }
};
