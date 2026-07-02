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
     Schema::create('weekly_submissions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->integer('week_number');
    $table->string('git_link');
    $table->string('report_file');
    
    // 📅 Date Columns Added Safely
    $table->date('assigned_date');
    $table->date('deadline_date');
    $table->timestamp('submission_date')->useCurrent(); // 🔒 Automatic current dynamic timestamp
    
    $table->string('status')->default('pending'); // pending, approved, rejected
    $table->text('feedback')->nullable();
    $table->integer('rating')->nullable();
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_submissions');
    }
};
