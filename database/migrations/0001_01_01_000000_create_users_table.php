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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();


            // Additional user details
$table->boolean('is_suspended')->default(false);
$table->unsignedBigInteger('referred_by')->nullable();
$table->decimal('referral_income', 8, 2)->default(0);
$table->string('referral_code')->nullable();
$table->timestamp('last_login_at')->nullable();

// Personal information
$table->string('firstName')->nullable();
$table->string('middleName')->nullable();
$table->string('lastName')->nullable();
$table->date('dateOfBirth')->nullable();
$table->string('gender')->nullable();
$table->string('phoneNumber')->nullable();

// Address information
$table->string('street')->nullable();
$table->string('city')->nullable();
$table->string('state')->nullable();
$table->string('postalCode')->nullable();
$table->string('country')->nullable();

// Additional settings
$table->string('profile_picture')->nullable();
$table->string('preferredLanguage')->nullable();
$table->text('specialAccommodations')->nullable();


        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });



        Schema::create('login_histories', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('user_id');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('location')->nullable();
            $table->string('device')->nullable();
            $table->string('session_id')->nullable();
            $table->string('login_method')->nullable();
            $table->string('login_status')->nullable();
            $table->timestamps();

            // Adding foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    // Drop foreign key constraints
    Schema::table('login_histories', function (Blueprint $table) {
    $table->dropForeign(['user_id']);
    });
    
    // Drop the tables
    Schema::dropIfExists('login_histories');
    Schema::dropIfExists('sessions');
    Schema::dropIfExists('password_reset_tokens');
    Schema::dropIfExists('users');
    }
};
