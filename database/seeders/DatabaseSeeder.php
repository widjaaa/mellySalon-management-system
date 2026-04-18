<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user - hanya membuat akun admin
        User::factory()->create([
            'name' => 'Admin Melly',
            'email' => 'admin@mellysalon.com',
            'password' => Hash::make('mellysalon123'),
        ]);

        // Data layanan dan member dikosongkan
        // Silakan isi data asli melalui halaman Layanan dan Member di aplikasi
    }
}

