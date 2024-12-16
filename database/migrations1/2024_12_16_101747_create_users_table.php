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
$table->increments('id');
$table->string('name');
$table->string('email')->unique();
$table->string('password');
$table->timestamp('email_verified_at')->nullable();
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
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('users');
}
};