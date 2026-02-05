<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create administrator
        if (! User::where('email', 'admin@gudele-hospital.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@gudele-hospital.com',
                'phone' => '+251-900-000-000',
                'password' => Hash::make('admin@123'),
                'role' => 'admin',
                'status' => 'active',
            ]);
        }

        // Create a doctor
        if (! User::where('email', 'doctor@gudele-hospital.com')->exists()) {
            User::create([
                'name' => 'Dr. Abebe Haile',
                'email' => 'doctor@gudele-hospital.com',
                'phone' => '+251-911-234-567',
                'password' => Hash::make('doctor@123'),
                'role' => 'doctor',
                'status' => 'active',
            ]);
        }

        // Create a registration/reception user
        if (! User::where('email', 'reception@gudele-hospital.com')->exists()) {
            User::create([
                'name' => 'Meskerem Tadesse',
                'email' => 'reception@gudele-hospital.com',
                'phone' => '+251-922-345-678',
                'password' => Hash::make('reception@123'),
                'role' => 'registration',
                'status' => 'active',
            ]);
        }
    }
}
