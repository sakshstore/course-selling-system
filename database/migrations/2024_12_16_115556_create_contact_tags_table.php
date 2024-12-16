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
        Schema::create('contact_tag', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

// Adding foreign key constraints
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade')->onUpdate('no action');
        });
    }

/**
 * Reverse the migrations.
 */
    public function down(): void
    {
        Schema::table('contact_tag', function (Blueprint $table) {
            $table->dropForeign(['contact_id']);
            $table->dropForeign(['tag_id']);
        });

        Schema::dropIfExists('contact_tag');
    }
};
