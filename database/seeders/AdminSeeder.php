<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@sumbawa.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample seniman users
        $senimanList = [
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@email.com'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@email.com'],
            ['name' => 'Ahmad Wijaya', 'email' => 'ahmad.wijaya@email.com'],
        ];

        foreach ($senimanList as $seniman) {
            User::firstOrCreate(
                ['email' => $seniman['email']],
                [
                    'name' => $seniman['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'seniman',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
