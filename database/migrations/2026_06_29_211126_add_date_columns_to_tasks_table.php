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
    Schema::table('tasks', function (Blueprint $table) {
        if (!Schema::hasColumn('tasks', 'assigned_date')) {
            $table->date('assigned_date')->nullable();
        }
        if (!Schema::hasColumn('tasks', 'deadline')) {
            $table->date('deadline')->nullable();
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
};
