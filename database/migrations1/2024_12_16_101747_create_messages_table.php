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
Schema::create('messages', function (Blueprint $table) {
$table->increments('id');
$table->unsignedBigInteger('ticket_id');
$table->unsignedBigInteger('user_id');
$table->text('message');
$table->boolean('is_read')->default(false);
$table->string('attachment')->nullable();
$table->string('message_type')->default('customer');
$table->unsignedBigInteger('parent_message_id')->nullable();
$table->timestamps();
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('messages');
}
};