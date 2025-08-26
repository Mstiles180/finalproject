<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sector;
use App\Models\Cell;

class CellSeeder extends Seeder
{
    public function run()
    {
        // Real Rwandan cells per sector
        $cellData = [
            // Gasabo District Sectors
            'Gisozi' => ['Gisozi', 'Kinyana', 'Nyarutarama'],
            'Kacyiru' => ['Kacyiru', 'Kagugu', 'Rukiri I', 'Rukiri II'],
            'Kimihurura' => ['Kimihurura', 'Kiyovu', 'Rugando'],
            'Kimironko' => ['Bibare', 'Kimironko I', 'Kimironko II', 'Nyagatovu'],
            'Kinyinya' => ['Kinyinya', 'Ndera', 'Nduba'],
            'Ndera' => ['Ndera', 'Rusororo'],
            'Nduba' => ['Nduba', 'Rutunga'],
            'Remera' => ['Gishushu', 'Kagugu', 'Nyabugogo'],
            'Rusororo' => ['Rusororo', 'Rutunga'],
            'Rutunga' => ['Rutunga', 'Kinyinya'],
            
            // Kicukiro District Sectors
            'Gatenga' => ['Gatenga', 'Kagunga', 'Kamashashi'],
            'Gikondo' => ['Gikondo', 'Kigarama', 'Masaka'],
            'Kagarama' => ['Kagarama', 'Kicukiro', 'Nyarugunga'],
            'Kanombe' => ['Kanombe', 'Kigali', 'Kimisagara'],
            'Kicukiro' => ['Kicukiro', 'Niboye', 'Nyamirambo'],
            'Kigarama' => ['Kigarama', 'Masaka', 'Niboye'],
            'Masaka' => ['Masaka', 'Nyarugunga'],
            'Niboye' => ['Niboye', 'Nyamirambo'],
            'Nyarugunga' => ['Nyarugunga', 'Kicukiro'],
            
            // Nyarugenge District Sectors
            'Gitega' => ['Gitega', 'Kanyinya', 'Kigali'],
            'Kanyinya' => ['Kanyinya', 'Kimisagara', 'Mageragere'],
            'Kigali' => ['Kigali', 'Kimisagara', 'Muhima'],
            'Kimisagara' => ['Kimisagara', 'Mageragere', 'Nyakabanda'],
            'Mageragere' => ['Mageragere', 'Muhima', 'Nyamirambo'],
            'Muhima' => ['Muhima', 'Nyakabanda', 'Nyarugenge'],
            'Nyakabanda' => ['Nyakabanda', 'Nyamirambo', 'Rwezamenyo'],
            'Nyamirambo' => ['Nyamirambo', 'Nyarugenge', 'Rwezamenyo'],
            'Nyarugenge' => ['Nyarugenge', 'Rwezamenyo'],
            'Rwezamenyo' => ['Rwezamenyo', 'Gitega'],
            
            // Huye District Sectors
            'Gishamvu' => ['Gishamvu', 'Karama', 'Kigoma'],
            'Karama' => ['Karama', 'Kinazi', 'Mukura'],
            'Kigoma' => ['Kigoma', 'Ngoma', 'Ruhashya'],
            'Kinazi' => ['Kinazi', 'Rusatira', 'Rwaniro'],
            'Mukura' => ['Mukura', 'Simbi', 'Gishamvu'],
            'Ngoma' => ['Ngoma', 'Ruhashya', 'Rusatira'],
            'Ruhashya' => ['Ruhashya', 'Rwaniro', 'Simbi'],
            'Rusatira' => ['Rusatira', 'Gishamvu', 'Karama'],
            'Rwaniro' => ['Rwaniro', 'Kigoma', 'Kinazi'],
            'Simbi' => ['Simbi', 'Mukura', 'Ngoma'],
            
            // Muhanga District Sectors
            'Cyeza' => ['Cyeza', 'Kibangu', 'Kiyumba'],
            'Kibangu' => ['Kibangu', 'Muhanga', 'Munyinya'],
            'Kiyumba' => ['Kiyumba', 'Musezero', 'Nyabinoni'],
            'Muhanga' => ['Muhanga', 'Nyamabuye', 'Nyarusange'],
            'Munyinya' => ['Munyinya', 'Rongi', 'Cyeza'],
            'Musezero' => ['Musezero', 'Kibangu', 'Kiyumba'],
            'Nyabinoni' => ['Nyabinoni', 'Muhanga', 'Munyinya'],
            'Nyamabuye' => ['Nyamabuye', 'Nyarusange', 'Rongi'],
            'Nyarusange' => ['Nyarusange', 'Cyeza', 'Kibangu'],
            'Rongi' => ['Rongi', 'Kiyumba', 'Musezero']
        ];

        foreach ($cellData as $sectorName => $cells) {
            $sector = Sector::where('name', $sectorName)->first();
            if ($sector) {
                foreach ($cells as $index => $cellName) {
                    Cell::create([
                        'name' => $cellName,
                        'code' => $sector->code . '-C' . ($index + 1),
                        'sector_id' => $sector->id,
                    ]);
                }
            }
        }
        
        // For sectors not in the specific list, create some generic cells
        $remainingSectors = Sector::whereNotIn('name', array_keys($cellData))->get();
        foreach ($remainingSectors as $sector) {
            $genericCells = ['Central', 'North', 'South', 'East', 'West'];
            foreach ($genericCells as $index => $cellName) {
                Cell::create([
                    'name' => $cellName . ' Cell',
                    'code' => $sector->code . '-C' . ($index + 1),
                    'sector_id' => $sector->id,
                ]);
            }
        }
    }
}