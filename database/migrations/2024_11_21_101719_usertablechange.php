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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('referred_by')->nullable()->after('id');
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
            $table->decimal('referral_income', 8, 2)->default(0)->after('referred_by');
            $table->string('referral_code')->nullable()->after('referral_income');
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
