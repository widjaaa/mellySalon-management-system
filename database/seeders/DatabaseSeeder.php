<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Member;
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
        // Admin user
        User::factory()->create([
            'name' => 'Admin Melly',
            'email' => 'admin@mellysalon.com',
            'password' => Hash::make('mellysalon123'),
        ]);

        // Sample services
        $services = [
            ['name' => 'Potong Rambut Wanita', 'category' => 'Rambut', 'price' => 75000, 'duration' => 45, 'description' => 'Potong rambut dengan konsultasi gaya terkini'],
            ['name' => 'Creambath', 'category' => 'Rambut', 'price' => 85000, 'duration' => 60, 'description' => 'Perawatan rambut dengan cream nutrisi'],
            ['name' => 'Hair Coloring', 'category' => 'Rambut', 'price' => 250000, 'duration' => 120, 'description' => 'Pewarnaan rambut premium dengan berbagai pilihan warna'],
            ['name' => 'Smoothing', 'category' => 'Rambut', 'price' => 350000, 'duration' => 180, 'description' => 'Pelurusan rambut tahan lama'],
            ['name' => 'Facial Basic', 'category' => 'Wajah', 'price' => 120000, 'duration' => 60, 'description' => 'Perawatan wajah dasar dengan pembersihan mendalam'],
            ['name' => 'Facial Glow', 'category' => 'Wajah', 'price' => 200000, 'duration' => 75, 'description' => 'Facial premium untuk kulit bersinar'],
            ['name' => 'Manicure', 'category' => 'Kuku', 'price' => 65000, 'duration' => 45, 'description' => 'Perawatan kuku tangan lengkap'],
            ['name' => 'Pedicure', 'category' => 'Kuku', 'price' => 75000, 'duration' => 50, 'description' => 'Perawatan kuku kaki lengkap'],
            ['name' => 'Body Massage', 'category' => 'Tubuh', 'price' => 150000, 'duration' => 60, 'description' => 'Pijat relaksasi seluruh tubuh'],
            ['name' => 'Lulur & Scrub', 'category' => 'Tubuh', 'price' => 175000, 'duration' => 75, 'description' => 'Perawatan kulit tubuh dengan lulur tradisional'],
            ['name' => 'Paket Pengantin', 'category' => 'Paket', 'price' => 1500000, 'duration' => 300, 'description' => 'Paket lengkap makeup, rambut, dan perawatan untuk pengantin'],
            ['name' => 'Paket Glowing', 'category' => 'Paket', 'price' => 450000, 'duration' => 150, 'description' => 'Facial + lulur + creambath untuk tampil glowing'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Sample members
        $members = [
            ['name' => 'Siti Nurhaliza', 'phone' => '081234567890', 'tier' => 'Gold', 'bday' => '15 Jan', 'poin' => 2500, 'total_visits' => 25, 'total_spent' => 3750000],
            ['name' => 'Dewi Persik', 'phone' => '081298765432', 'tier' => 'Silver', 'bday' => '22 Mar', 'poin' => 1200, 'total_visits' => 12, 'total_spent' => 1800000],
            ['name' => 'Raisa Andriana', 'phone' => '085612345678', 'tier' => 'Gold', 'bday' => '06 Jun', 'poin' => 3100, 'total_visits' => 30, 'total_spent' => 4650000],
            ['name' => 'Bunga Citra', 'phone' => '087812340987', 'tier' => 'Bronze', 'bday' => '18 Sep', 'poin' => 450, 'total_visits' => 5, 'total_spent' => 600000],
            ['name' => 'Ariel Tatum', 'phone' => '081356781234', 'tier' => 'Silver', 'bday' => '30 Nov', 'poin' => 980, 'total_visits' => 10, 'total_spent' => 1500000],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
