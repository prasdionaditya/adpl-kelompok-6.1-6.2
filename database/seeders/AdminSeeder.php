<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin UMKM',
            'email' => 'admin@umkm.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample UMKM user
        $umkmUser = User::create([
            'name' => 'Toko Kue Ibu Sari',
            'email' => 'sari@umkm.com',
            'password' => Hash::make('password123'),
            'role' => 'umkm',
            'phone' => '081234567890',
            'address' => 'Jl. Raya No. 123, Kendari',
            'email_verified_at' => now(),
        ]);

        // Create UMKM Profile
        $umkmUser->umkmProfile()->create([
            'store_name' => 'Toko Kue Ibu Sari',
            'store_description' => 'Menyediakan berbagai macam kue tradisional dan modern dengan cita rasa yang lezat.',
            'store_address' => 'Jl. Raya No. 123, Kendari, Sulawesi Tenggara',
            'latitude' => -3.9778,
            'longitude' => 122.5194,
        ]);

        // Create sample buyer
        User::create([
            'name' => 'John Buyer',
            'email' => 'buyer@test.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'phone' => '081234567891',
            'address' => 'Jl. Pembeli No. 456, Kendari',
            'email_verified_at' => now(),
        ]);

        echo "Admin and sample users created successfully!\n";
        echo "Admin: admin@umkm.com / password123\n";
        echo "UMKM: sari@umkm.com / password123\n";
        echo "Buyer: buyer@test.com / password123\n";
    }
}