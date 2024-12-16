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
$table->id(); // Auto-incrementing ID
$table->string('type');
$table->string('subject')->nullable();
$table->text('message');
$table->unsignedBigInteger('user_id');
$table->string('status')->default('pending');
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
Schema::table('campaigns', function (Blueprint $table) {
$table->dropForeign(['user_id']);
});

Schema::dropIfExists('campaigns');
}
};