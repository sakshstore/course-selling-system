<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('invoices');

        Schema::dropIfExists('invoice_product');
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
         
            $table->string('customer_id');
            $table->string('invoice_number');

            $table->string('order_number')->nullable();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->text('customer_note')->nullable();
            $table->text('terms')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });


        Schema::create('invoice_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
