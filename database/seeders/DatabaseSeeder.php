<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@trip.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0123456789',
        ]);

        // Staff
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@trip.test',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '0123456790',
        ]);

        // Customer
        User::create([
            'name' => 'Customer One',
            'email' => 'customer@trip.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '0123456791',
        ]);

        // Sample Trips
        Trip::create([
            'title' => 'Tokyo Cherry Blossom Tour',
            'description' => 'Enjoy the beautiful cherry blossom season in Tokyo.',
            'destination' => 'Tokyo, Japan',
            'departure_date' => '2026-11-01',
            'return_date' => '2026-11-07',
            'price' => 5500.00,
            'max_capacity' => 40,
            'status' => 'open',
            'created_by' => $admin->id,
        ]);

        Trip::create([
            'title' => 'Bali Beach Getaway',
            'description' => 'Relaxing 5-day trip to Bali beaches and temples.',
            'destination' => 'Bali, Indonesia',
            'departure_date' => '2026-12-10',
            'return_date' => '2026-12-15',
            'price' => 2200.00,
            'max_capacity' => 30,
            'status' => 'open',
            'created_by' => $admin->id,
        ]);

        Trip::create([
            'title' => 'Seoul Winter Trip',
            'description' => 'Experience winter in Seoul with skiing included.',
            'destination' => 'Seoul, South Korea',
            'departure_date' => '2027-01-20',
            'return_date' => '2027-01-27',
            'price' => 4800.00,
            'max_capacity' => 25,
            'status' => 'open',
            'created_by' => $admin->id,
        ]);
    }
}