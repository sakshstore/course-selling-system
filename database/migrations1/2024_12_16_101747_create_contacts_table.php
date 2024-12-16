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
Schema::create('contacts', function (Blueprint $table) {
$table->increments('id');
$table->unsignedBigInteger('user_id');
$table->string('name');
$table->string('email')->unique();
$table->string('phone');
$table->string('status');
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
Schema::table('contacts', function (Blueprint $table) {
$table->dropForeign(['user_id']);
});

Schema::dropIfExists('contacts');
}
};