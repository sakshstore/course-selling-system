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
    {  Schema::dropIfExists('invoices');
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number');
            $table->string('order_number')->nullable();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->text('customer_note')->nullable();
            $table->text('terms')->nullable();
            $table->enum('status', ['draft', 'sent', 'viewed', 'paid', 'partially_paid', 'overdue', 'cancelled']);
            $table->string('file_path')->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
