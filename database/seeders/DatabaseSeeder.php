<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed administrative data only if not already present
        if (\App\Models\Province::count() === 0) {
            $this->call([
                ProvinceSeeder::class,
                DistrictSeeder::class,
                SectorSeeder::class,
                CellSeeder::class,
                VillageSeeder::class,
                PickupPointSeeder::class,
            ]);
        }

        // Ensure a single test user exists without duplicates
        \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'worker',
            ]
        );

        // Seed default admin user (requested credentials)
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('mstiles@123'),
                'role' => 'admin',
            ]
        );
    }
}
