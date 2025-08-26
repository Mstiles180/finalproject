<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
    public function run()
    {
        // Real Rwandan sectors per district
        $sectorData = [
            // Gasabo District (Kigali City)
            'Gasabo' => [
                'Gisozi', 'Kacyiru', 'Kimihurura', 'Kimironko', 'Kinyinya', 
                'Ndera', 'Nduba', 'Remera', 'Rusororo', 'Rutunga'
            ],
            
            // Kicukiro District (Kigali City)
            'Kicukiro' => [
                'Gatenga', 'Gikondo', 'Kagarama', 'Kanombe', 'Kicukiro', 
                'Kigarama', 'Masaka', 'Niboye', 'Nyarugunga'
            ],
            
            // Nyarugenge District (Kigali City)
            'Nyarugenge' => [
                'Gitega', 'Kanyinya', 'Kigali', 'Kimisagara', 'Mageragere', 
                'Muhima', 'Nyakabanda', 'Nyamirambo', 'Nyarugenge', 'Rwezamenyo'
            ],
            
            // Huye District (Southern Province)
            'Huye' => [
                'Gishamvu', 'Karama', 'Kigoma', 'Kinazi', 'Mukura', 
                'Ngoma', 'Ruhashya', 'Rusatira', 'Rwaniro', 'Simbi'
            ],
            
            // Muhanga District (Southern Province)
            'Muhanga' => [
                'Cyeza', 'Kibangu', 'Kiyumba', 'Muhanga', 'Munyinya', 
                'Musezero', 'Nyabinoni', 'Nyamabuye', 'Nyarusange', 'Rongi'
            ],
            
            // Musanze District (Northern Province)
            'Musanze' => [
                'Busogo', 'Cyuve', 'Gacaca', 'Gashaki', 'Gataraga', 
                'Kimonyi', 'Kinigi', 'Muhoza', 'Muko', 'Musanze', 'Nkotsi', 'Rwaza'
            ],
            
            // Rubavu District (Western Province)
            'Rubavu' => [
                'Bugeshi', 'Busasamana', 'Cyanzarwe', 'Gisenyi', 'Kanama', 
                'Kanzenze', 'Mudende', 'Nyakiriba', 'Nyamyumba', 'Nyundo', 'Rubavu', 'Rugerero'
            ],
            
            // Kayonza District (Eastern Province)
            'Kayonza' => [
                'Gahini', 'Kabarondo', 'Kayonza', 'Mukarange', 'Murama', 
                'Murundi', 'Mwiri', 'Ndama', 'Nyamirama', 'Rukara', 'Rukara', 'Ruramira'
            ]
        ];

        foreach ($sectorData as $districtName => $sectors) {
            $district = District::where('name', $districtName)->first();
            if ($district) {
                foreach ($sectors as $index => $sectorName) {
                    Sector::create([
                        'name' => $sectorName,
                        'code' => $district->code . '-S' . ($index + 1),
                        'district_id' => $district->id,
                    ]);
                }
            }
        }
        
        // For districts not in the specific list, create some generic sectors
        $remainingDistricts = District::whereNotIn('name', array_keys($sectorData))->get();
        foreach ($remainingDistricts as $district) {
            $genericSectors = ['Central', 'North', 'South', 'East', 'West'];
            foreach ($genericSectors as $index => $sectorName) {
                Sector::create([
                    'name' => $sectorName . ' Sector',
                    'code' => $district->code . '-S' . ($index + 1),
                    'district_id' => $district->id,
                ]);
            }
        }
    }
}