<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'peso@tagudin.gov.ph'],
            [
                'name' => 'PESO Administrator',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample job seekers
        $seekers = [
            ['name' => 'Juan Dela Cruz', 'email' => 'juan@example.com'],
            ['name' => 'Maria Santos', 'email' => 'maria@example.com'],
            ['name' => 'Pedro Gonzales', 'email' => 'pedro@example.com'],
            ['name' => 'Ana Bautista', 'email' => 'ana@example.com'],
        ];

        foreach ($seekers as $seeker) {
            $user = User::firstOrCreate(
                ['email' => $seeker['email']],
                [
                    'name' => $seeker['name'],
                    'password' => bcrypt('password'),
                    'role' => 'job_seeker',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            // Create profile for each job seeker
            $user->profile()->create([
                'phone' => '09' . rand(100000000, 999999999),
                'address' => 'Poblacion, Tagudin, Ilocos Sur',
                'city' => 'Tagudin',
                'province' => 'Ilocos Sur',
                'skills' => 'Communication, Teamwork, MS Office, ' . fake()->randomElement(['Customer Service', 'Data Entry', 'Bookkeeping', 'Administrative Support']),
                'education' => fake()->randomElement([
                    "Bachelor of Science in Business Administration\nUniversity of Northern Philippines\nGraduated: 2020",
                    "Bachelor of Arts in Public Administration\nIlocos Sur Polytechnic State College\nGraduated: 2019",
                    "Associate in Computer Technology\nSTI College\nGraduated: 2021",
                ]),
            ]);
        }
    }
}
