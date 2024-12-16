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
        Schema::table('contact_tag', function (Blueprint $table) {
            $table->foreign(['tag_id'], null)->references(['id'])->on('tags')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['contact_id'], null)->references(['id'])->on('contacts')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_tag', function (Blueprint $table) {
            $table->dropForeign();
            $table->dropForeign();
        });
    }
};
