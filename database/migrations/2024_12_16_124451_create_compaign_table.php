<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('type');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('recipients', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('contact');
            $table->unsignedBigInteger('campaign_id');
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('recipients', function (Blueprint $table) {
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade')->onUpdate('no action');
        });
    }

    public function down(): void
    {
// Drop foreign key constraints
        Schema::table('recipients', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

// Drop the tables
        Schema::dropIfExists('recipients');
        Schema::dropIfExists('campaigns');
    }
};
