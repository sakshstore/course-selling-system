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
        Schema::dropIfExists('products');

        
        
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->decimal('price', 8, 2);
    $table->string('sku')->unique();
    $table->unsignedBigInteger('category_id');
    $table->integer('stock_quantity');
    $table->string('image_url');
    $table->enum('status', ['available', 'unavailable']);
    $table->decimal('discount', 5, 2)->nullable();
    $table->decimal('weight', 5, 2)->nullable();
    $table->string('dimensions')->nullable();
    $table->string('tags')->nullable();
    $table->unsignedBigInteger('user_id');
    $table->timestamps();
    
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
