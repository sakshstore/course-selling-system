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
        Schema::table('invoice_product', function (Blueprint $table) {
            $table->foreign(['product_id'], null)->references(['id'])->on('products')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['invoice_id'], null)->references(['id'])->on('invoices')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_product', function (Blueprint $table) {
            $table->dropForeign();
            $table->dropForeign();
        });
    }
};
