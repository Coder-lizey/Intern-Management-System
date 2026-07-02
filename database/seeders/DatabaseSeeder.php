<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Yeh line call karein taake UserSeeder chal sake:
    $this->call(UserSeeder::class);
}
}