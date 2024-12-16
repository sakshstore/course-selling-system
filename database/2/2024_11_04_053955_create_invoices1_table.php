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
    {Schema::dropIfExists('invoices');
    Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
    $table->string('invoice_number');
    $table->string('order_number')->nullable();
    $table->date('invoice_date');
    $table->date('due_date');
    $table->text('customer_note')->nullable();
    $table->text('terms')->nullable();
    $table->string('file_path')->nullable();
    $table->timestamps();
    });
    }
    
    public function down()
    {
    Schema::dropIfExists('invoices');
    }
};
