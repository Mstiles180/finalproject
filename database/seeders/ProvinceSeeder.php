<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $provinces = [
            ['name' => 'Kigali City', 'code' => 'KG'],
            ['name' => 'Northern Province', 'code' => 'NP'],
            ['name' => 'Southern Province', 'code' => 'SP'],
            ['name' => 'Eastern Province', 'code' => 'EP'],
            ['name' => 'Western Province', 'code' => 'WP'],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }
} 