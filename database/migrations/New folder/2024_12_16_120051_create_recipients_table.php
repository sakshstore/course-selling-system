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
Schema::create('recipients', function (Blueprint $table) {
$table->id(); // Auto-incrementing ID
$table->string('contact');
$table->unsignedBigInteger('campaign_id');
$table->string('status')->nullable();
$table->timestamps();

// Adding foreign key constraint
$table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade')->onUpdate('no action');
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::table('recipients', function (Blueprint $table) {
$table->dropForeign(['campaign_id']);
});

Schema::dropIfExists('recipients');
}
};