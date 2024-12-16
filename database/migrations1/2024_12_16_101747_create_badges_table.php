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
Schema::create('badges', function (Blueprint $table) {
$table->increments('id');
$table->unsignedBigInteger('user_id');
$table->string('name');
$table->string('description');
$table->string('icon');
$table->string('event_name');
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
Schema::table('badges', function (Blueprint $table) {
$table->dropForeign(['user_id']);
});

Schema::dropIfExists('badges');
}
};
