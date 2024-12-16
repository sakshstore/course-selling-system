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
        Schema::dropIfExists('invoices');

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->date('date');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('tax', 10, 2)->nullable();
            $table->enum('status', ['pending', 'paid', 'cancelled']);
            $table->timestamps();
            
            // Add foreign key constraint
            $table->foreign('customer_id')->references('id')->on('lead')->onDelete('cascade');
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
