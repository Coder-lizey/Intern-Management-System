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
    Schema::create('certificates', function (Blueprint $table) {
        $table->id();
        // Yeh column user table ki id se connect hoga
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        // Status tracking columns
        $table->integer('approved_weeks_count')->default(0); // 0 to 4 weeks
        $table->boolean('is_unlocked')->default(false); // false = Locked, true = Unlocked
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
