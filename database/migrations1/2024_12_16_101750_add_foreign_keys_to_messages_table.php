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
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign(['parent_message_id'], null)->references(['id'])->on('messages')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'], null)->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['ticket_id'], null)->references(['id'])->on('tickets')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign();
            $table->dropForeign();
            $table->dropForeign();
        });
    }
};
