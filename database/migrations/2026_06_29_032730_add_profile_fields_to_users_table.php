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
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable();
        $table->text('address')->nullable();
        $table->string('university')->nullable();
        $table->string('degree')->nullable();
        $table->string('avatar')->nullable(); // For profile image
        
        // Yeh do naye columns yahan add karlein:
        $table->string('department')->nullable(); // Web Development, Software Engineering etc.
        $table->integer('unlocked_week')->default(1); // Intern ka week track karne ke liye (1 se 4)
    });
}

    /**
     * Reverse the migrations.
     */
  public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['phone', 'address', 'university', 'degree', 'avatar', 'department', 'unlocked_week']);
    });
}
};
