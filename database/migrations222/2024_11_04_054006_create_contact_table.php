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
    {Schema::dropIfExists('contacts');
    Schema::create('contacts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->string('email')->unique();
    $table->string('phone');
    $table->string('status'); // 'lead' or 'customer'
    $table->timestamps();
    });
    }
    
    public function down()
    {
    Schema::dropIfExists('contacts');
    }
};

