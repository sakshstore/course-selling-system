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
        Schema::table('playlist_study_material', function (Blueprint $table) {
            $table->foreign(['study_material_id'], null)->references(['id'])->on('study_materials')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['playlist_id'], null)->references(['id'])->on('playlists')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('playlist_study_material', function (Blueprint $table) {
            $table->dropForeign();
            $table->dropForeign();
        });
    }
};
