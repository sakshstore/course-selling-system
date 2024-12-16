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
Schema::create('campaigns', function (Blueprint $table) {
$table->increments('id');
$table->unsignedBigInteger('user_id');
$table->text('type');
$table->text('message');
$table->text('status')->nullable();
$table->text('subject')->nullable();
$table->timestamps();
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('campaigns');
}
};