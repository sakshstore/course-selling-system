Sure! Here's a migration script for your playlists table, suitable for MySQL 8 and Laravel 11:

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
Schema::create('playlists', function (Blueprint $table) {
$table->increments('id');
$table->string('name');
$table->unsignedBigInteger('course_id');
$table->unsignedBigInteger('user_id');
$table->timestamps();
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('playlists');
}
};
