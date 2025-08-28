<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Dinas Kebudayaan',
            'email' => 'admin@dinasbudaya.go.id',
            'password' => bcrypt('password123'),
            'phone' => '081234567890',
            'address' => 'Jl. Dinas Kebudayaan No. 1',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample venues
        \App\Models\Venue::create([
            'name' => 'Gedung Serba Guna',
            'description' => 'Gedung serba guna untuk berbagai acara kebudayaan',
            'capacity' => 500,
            'price_per_day' => 5000000,
            'facilities' => json_encode(['AC', 'Panggung', 'Sound System', 'Lighting', 'Kursi']),
            'images' => json_encode(['venue1.jpg', 'venue2.jpg']),
            'is_active' => true,
        ]);

        \App\Models\Venue::create([
            'name' => 'Auditorium Budaya',
            'description' => 'Auditorium modern untuk pertunjukan seni',
            'capacity' => 300,
            'price_per_day' => 7500000,
            'facilities' => json_encode(['AC', 'Panggung Tetap', 'Sound System Profesional', 'Lighting Theater', 'Kursi Theater']),
            'images' => json_encode(['auditorium1.jpg', 'auditorium2.jpg']),
            'is_active' => true,
        ]);
    }
}