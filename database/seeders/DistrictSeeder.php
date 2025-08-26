<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\Province;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        $districts = [
            // Kigali City
            ['name' => 'Gasabo', 'code' => 'GAS', 'province_code' => 'KG'],
            ['name' => 'Kicukiro', 'code' => 'KIC', 'province_code' => 'KG'],
            ['name' => 'Nyarugenge', 'code' => 'NYG', 'province_code' => 'KG'],
            
            // Northern Province
            ['name' => 'Burera', 'code' => 'BUR', 'province_code' => 'NP'],
            ['name' => 'Gakenke', 'code' => 'GAK', 'province_code' => 'NP'],
            ['name' => 'Gicumbi', 'code' => 'GIC', 'province_code' => 'NP'],
            ['name' => 'Musanze', 'code' => 'MUS', 'province_code' => 'NP'],
            ['name' => 'Rulindo', 'code' => 'RUL', 'province_code' => 'NP'],
            
            // Southern Province
            ['name' => 'Gisagara', 'code' => 'GIS', 'province_code' => 'SP'],
            ['name' => 'Huye', 'code' => 'HUY', 'province_code' => 'SP'],
            ['name' => 'Kamonyi', 'code' => 'KAM', 'province_code' => 'SP'],
            ['name' => 'Muhanga', 'code' => 'MUH', 'province_code' => 'SP'],
            ['name' => 'Nyamagabe', 'code' => 'NYB', 'province_code' => 'SP'],
            ['name' => 'Nyanza', 'code' => 'NYZ', 'province_code' => 'SP'],
            ['name' => 'Nyaruguru', 'code' => 'NYR', 'province_code' => 'SP'],
            ['name' => 'Ruhango', 'code' => 'RUH', 'province_code' => 'SP'],
            
            // Eastern Province
            ['name' => 'Bugesera', 'code' => 'BUG', 'province_code' => 'EP'],
            ['name' => 'Gatsibo', 'code' => 'GAT', 'province_code' => 'EP'],
            ['name' => 'Kayonza', 'code' => 'KAY', 'province_code' => 'EP'],
            ['name' => 'Kirehe', 'code' => 'KIR', 'province_code' => 'EP'],
            ['name' => 'Ngoma', 'code' => 'NGM', 'province_code' => 'EP'],
            ['name' => 'Nyagatare', 'code' => 'NYT', 'province_code' => 'EP'],
            ['name' => 'Rwamagana', 'code' => 'RWA', 'province_code' => 'EP'],
            
            // Western Province
            ['name' => 'Karongi', 'code' => 'KAR', 'province_code' => 'WP'],
            ['name' => 'Ngororero', 'code' => 'NGR', 'province_code' => 'WP'],
            ['name' => 'Nyabihu', 'code' => 'NYH', 'province_code' => 'WP'],
            ['name' => 'Nyamasheke', 'code' => 'NYS', 'province_code' => 'WP'],
            ['name' => 'Rubavu', 'code' => 'RUB', 'province_code' => 'WP'],
            ['name' => 'Rusizi', 'code' => 'RUS', 'province_code' => 'WP'],
            ['name' => 'Rutsiro', 'code' => 'RUT', 'province_code' => 'WP'],
        ];

        foreach ($districts as $district) {
            $province = Province::where('code', $district['province_code'])->first();
            if ($province) {
                District::create([
                    'name' => $district['name'],
                    'code' => $district['code'],
                    'province_id' => $province->id,
                ]);
            }
        }
    }
} 