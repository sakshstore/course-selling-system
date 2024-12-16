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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->decimal('price');
            $table->string('sku')->unique();
            $table->integer('category_id');
            $table->integer('stock_quantity');
            $table->string('image_url');
            $table->enum('status', ['available', 'unavailable']);
            $table->decimal('discount')->nullable();
            $table->decimal('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('tags')->nullable();
            $table->integer('user_id');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
