<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Remove duplicate namespace if any and make sure it looks clean like this:

        // 1. Mentors (Admins) Add Karein
        User::create([
            'name' => 'Sir Talha',
            'email' => 'talha@vergesystems.com',
            'password' => Hash::make('mentor@01'), 
            'role' => 'mentor',
            'phone' => '03001112223',
            'department' => 'Web Development', // Naya column
        ]);

        // 2. 5 Interns Add Karein
        $interns = [
            ['name' => 'Alizey Khan', 'email' => 'alizey@vergesystems.com', 'pass' => 'verge@01', 'dept' => 'Web Development'],
            ['name' => 'Intern Two', 'email' => 'intern2@vergesystems.com', 'pass' => 'verge02', 'dept' => 'Software Engineering'],
            ['name' => 'Intern Three', 'email' => 'intern3@vergesystems.com', 'pass' => 'verge03', 'dept' => 'Web Development'],
            ['name' => 'Intern Four', 'email' => 'intern4@vergesystems.com', 'pass' => 'verge04', 'dept' => 'UI/UX Design'],
            ['name' => 'Intern Five', 'email' => 'intern5@vergesystems.com', 'pass' => 'verge05', 'dept' => 'Mobile App Development'],
        ];

        foreach ($interns as $intern) {
            User::create([
                'name' => $intern['name'],
                'email' => $intern['email'],
                'password' => Hash::make($intern['pass']),
                'role' => 'intern',
                'phone' => '0333' . rand(1111111, 9999999), // Dummy Phone
                'university' => 'XYZ University',
                'degree' => 'BSCS',
                'department' => $intern['dept'], // Har intern ka apna department
                'unlocked_week' => 1, // Default Week 1 se start hoga
            ]);
        }
    }
}