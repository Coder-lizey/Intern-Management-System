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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 👈 Har intern ki ID save hogi
        $table->date('date');
        $table->time('check_in');
        $table->time('check_out')->nullable();
        $table->decimal('hours_worked', 5, 2)->nullable(); // e.g. 8.50 hours
        $table->integer('performance_percentage')->nullable(); // Calculate ho kar save hoga
        $table->string('status')->default('Present'); // Present, Absent, Late
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
