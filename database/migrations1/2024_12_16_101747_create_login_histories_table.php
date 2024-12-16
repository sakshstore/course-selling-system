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
Schema::create('login_histories', function (Blueprint $table) {
$table->increments('id');
$table->unsignedBigInteger('user_id');
$table->string('ip_address')->nullable();
$table->string('user_agent')->nullable();
$table->string('location')->nullable();
$table->string('device')->nullable();
$table->string('session_id')->nullable();
$table->string('login_method')->nullable();
$table->boolean('login_status')->default(true);
$table->timestamps();
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('login_histories');
}
};