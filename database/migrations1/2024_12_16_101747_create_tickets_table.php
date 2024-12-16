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
Schema::create('tickets', function (Blueprint $table) {
$table->increments('id');
$table->unsignedBigInteger('user_id');
$table->string('title');
$table->text('description');
$table->string('category');
$table->string('priority');
$table->string('status')->default('open');
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
Schema::table('tickets', function (Blueprint $table) {
$table->dropForeign(['user_id']);
});

Schema::dropIfExists('tickets');
}
};
