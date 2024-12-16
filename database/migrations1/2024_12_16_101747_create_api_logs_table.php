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
Schema::create('api_logs', function (Blueprint $table) {
$table->id();
$table->unsignedBigInteger('user_id');
$table->text('request_data')->nullable();
$table->text('response_data')->nullable();
$table->string('method');
$table->string('url');
$table->string('ip_address');
$table->string('user_agent');
$table->integer('response_status');
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
Schema::table('api_logs', function (Blueprint $table) {
$table->dropForeign(['user_id']);
});

Schema::dropIfExists('api_logs');
}
};