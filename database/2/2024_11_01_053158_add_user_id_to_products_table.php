<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    // Drop the existing products table if it exists
    Schema::dropIfExists('products');
    
    // Create the new products table
    Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id'); // Add user_id column
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->string('sku')->unique()->nullable();
    $table->unsignedBigInteger('category_id')->nullable();
    $table->integer('stock_quantity')->default(0);
    $table->unsignedBigInteger('supplier_id')->nullable();
    $table->string('image_url')->nullable();
    $table->enum('status', ['active', 'discontinued'])->default('active');
    $table->decimal('discount', 5, 2)->default(0.00);
    $table->decimal('weight', 10, 2)->nullable();
    $table->string('dimensions')->nullable();
    $table->string('tags')->nullable();
    $table->decimal('rating', 3, 2)->default(0.00);
    $table->integer('reviews_count')->default(0);
    $table->timestamps();
    
    // Foreign key constraints
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
    });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};