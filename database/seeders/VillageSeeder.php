<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cell;
use App\Models\Village;

class VillageSeeder extends Seeder
{
    public function run()
    {
        // Real Rwandan villages per cell
        $villageData = [
            // Gasabo District Cells
            'Gisozi' => ['Gisozi I', 'Gisozi II', 'Kinyana I', 'Kinyana II', 'Nyarutarama I', 'Nyarutarama II'],
            'Kacyiru' => ['Kacyiru I', 'Kacyiru II', 'Kagugu I', 'Kagugu II', 'Rukiri I', 'Rukiri II'],
            'Kimihurura' => ['Kimihurura I', 'Kimihurura II', 'Kiyovu I', 'Kiyovu II', 'Rugando I', 'Rugando II'],
            'Kimironko' => ['Bibare I', 'Bibare II', 'Kimironko I', 'Kimironko II', 'Nyagatovu I', 'Nyagatovu II'],
            'Kinyinya' => ['Kinyinya I', 'Kinyinya II', 'Ndera I', 'Ndera II', 'Nduba I', 'Nduba II'],
            'Ndera' => ['Ndera I', 'Ndera II', 'Rusororo I', 'Rusororo II'],
            'Nduba' => ['Nduba I', 'Nduba II', 'Rutunga I', 'Rutunga II'],
            'Remera' => ['Gishushu I', 'Gishushu II', 'Kagugu I', 'Kagugu II', 'Nyabugogo I', 'Nyabugogo II'],
            'Rusororo' => ['Rusororo I', 'Rusororo II', 'Rutunga I', 'Rutunga II'],
            'Rutunga' => ['Rutunga I', 'Rutunga II', 'Kinyinya I', 'Kinyinya II'],
            
            // Kicukiro District Cells
            'Gatenga' => ['Gatenga I', 'Gatenga II', 'Kagunga I', 'Kagunga II', 'Kamashashi I', 'Kamashashi II'],
            'Gikondo' => ['Gikondo I', 'Gikondo II', 'Kigarama I', 'Kigarama II', 'Masaka I', 'Masaka II'],
            'Kagarama' => ['Kagarama I', 'Kagarama II', 'Kicukiro I', 'Kicukiro II', 'Nyarugunga I', 'Nyarugunga II'],
            'Kanombe' => ['Kanombe I', 'Kanombe II', 'Kigali I', 'Kigali II', 'Kimisagara I', 'Kimisagara II'],
            'Kicukiro' => ['Kicukiro I', 'Kicukiro II', 'Niboye I', 'Niboye II', 'Nyamirambo I', 'Nyamirambo II'],
            'Kigarama' => ['Kigarama I', 'Kigarama II', 'Masaka I', 'Masaka II', 'Niboye I', 'Niboye II'],
            'Masaka' => ['Masaka I', 'Masaka II', 'Nyarugunga I', 'Nyarugunga II'],
            'Niboye' => ['Niboye I', 'Niboye II', 'Nyamirambo I', 'Nyamirambo II'],
            'Nyarugunga' => ['Nyarugunga I', 'Nyarugunga II', 'Kicukiro I', 'Kicukiro II'],
            
            // Nyarugenge District Cells
            'Gitega' => ['Gitega I', 'Gitega II', 'Kanyinya I', 'Kanyinya II', 'Kigali I', 'Kigali II'],
            'Kanyinya' => ['Kanyinya I', 'Kanyinya II', 'Kimisagara I', 'Kimisagara II', 'Mageragere I', 'Mageragere II'],
            'Kigali' => ['Kigali I', 'Kigali II', 'Kimisagara I', 'Kimisagara II', 'Muhima I', 'Muhima II'],
            'Kimisagara' => ['Kimisagara I', 'Kimisagara II', 'Mageragere I', 'Mageragere II', 'Nyakabanda I', 'Nyakabanda II'],
            'Mageragere' => ['Mageragere I', 'Mageragere II', 'Muhima I', 'Muhima II', 'Nyamirambo I', 'Nyamirambo II'],
            'Muhima' => ['Muhima I', 'Muhima II', 'Nyakabanda I', 'Nyakabanda II', 'Nyarugenge I', 'Nyarugenge II'],
            'Nyakabanda' => ['Nyakabanda I', 'Nyakabanda II', 'Nyamirambo I', 'Nyamirambo II', 'Rwezamenyo I', 'Rwezamenyo II'],
            'Nyamirambo' => ['Nyamirambo I', 'Nyamirambo II', 'Nyarugenge I', 'Nyarugenge II', 'Rwezamenyo I', 'Rwezamenyo II'],
            'Nyarugenge' => ['Nyarugenge I', 'Nyarugenge II', 'Rwezamenyo I', 'Rwezamenyo II'],
            'Rwezamenyo' => ['Rwezamenyo I', 'Rwezamenyo II', 'Gitega I', 'Gitega II'],
            
            // Huye District Cells
            'Gishamvu' => ['Gishamvu I', 'Gishamvu II', 'Karama I', 'Karama II', 'Kigoma I', 'Kigoma II'],
            'Karama' => ['Karama I', 'Karama II', 'Kinazi I', 'Kinazi II', 'Mukura I', 'Mukura II'],
            'Kigoma' => ['Kigoma I', 'Kigoma II', 'Ngoma I', 'Ngoma II', 'Ruhashya I', 'Ruhashya II'],
            'Kinazi' => ['Kinazi I', 'Kinazi II', 'Rusatira I', 'Rusatira II', 'Rwaniro I', 'Rwaniro II'],
            'Mukura' => ['Mukura I', 'Mukura II', 'Simbi I', 'Simbi II', 'Gishamvu I', 'Gishamvu II'],
            'Ngoma' => ['Ngoma I', 'Ngoma II', 'Ruhashya I', 'Ruhashya II', 'Rusatira I', 'Rusatira II'],
            'Ruhashya' => ['Ruhashya I', 'Ruhashya II', 'Rwaniro I', 'Rwaniro II', 'Simbi I', 'Simbi II'],
            'Rusatira' => ['Rusatira I', 'Rusatira II', 'Gishamvu I', 'Gishamvu II', 'Karama I', 'Karama II'],
            'Rwaniro' => ['Rwaniro I', 'Rwaniro II', 'Kigoma I', 'Kigoma II', 'Kinazi I', 'Kinazi II'],
            'Simbi' => ['Simbi I', 'Simbi II', 'Mukura I', 'Mukura II', 'Ngoma I', 'Ngoma II'],
            
            // Muhanga District Cells
            'Cyeza' => ['Cyeza I', 'Cyeza II', 'Kibangu I', 'Kibangu II', 'Kiyumba I', 'Kiyumba II'],
            'Kibangu' => ['Kibangu I', 'Kibangu II', 'Muhanga I', 'Muhanga II', 'Munyinya I', 'Munyinya II'],
            'Kiyumba' => ['Kiyumba I', 'Kiyumba II', 'Musezero I', 'Musezero II', 'Nyabinoni I', 'Nyabinoni II'],
            'Muhanga' => ['Muhanga I', 'Muhanga II', 'Nyamabuye I', 'Nyamabuye II', 'Nyarusange I', 'Nyarusange II'],
            'Munyinya' => ['Munyinya I', 'Munyinya II', 'Rongi I', 'Rongi II', 'Cyeza I', 'Cyeza II'],
            'Musezero' => ['Musezero I', 'Musezero II', 'Kibangu I', 'Kibangu II', 'Kiyumba I', 'Kiyumba II'],
            'Nyabinoni' => ['Nyabinoni I', 'Nyabinoni II', 'Muhanga I', 'Muhanga II', 'Munyinya I', 'Munyinya II'],
            'Nyamabuye' => ['Nyamabuye I', 'Nyamabuye II', 'Nyarusange I', 'Nyarusange II', 'Rongi I', 'Rongi II'],
            'Nyarusange' => ['Nyarusange I', 'Nyarusange II', 'Cyeza I', 'Cyeza II', 'Kibangu I', 'Kibangu II'],
            'Rongi' => ['Rongi I', 'Rongi II', 'Kiyumba I', 'Kiyumba II', 'Musezero I', 'Musezero II']
        ];

        foreach ($villageData as $cellName => $villages) {
            $cell = Cell::where('name', $cellName)->first();
            if ($cell) {
                foreach ($villages as $index => $villageName) {
                    Village::create([
                        'name' => $villageName,
                        'code' => $cell->code . '-V' . ($index + 1),
                        'cell_id' => $cell->id,
                    ]);
                }
            }
        }
        
        // For cells not in the specific list, create some generic villages
        $remainingCells = Cell::whereNotIn('name', array_keys($villageData))->get();
        foreach ($remainingCells as $cell) {
            $genericVillages = ['Central', 'North', 'South', 'East', 'West'];
            foreach ($genericVillages as $index => $villageName) {
                Village::create([
                    'name' => $villageName . ' Village',
                    'code' => $cell->code . '-V' . ($index + 1),
                    'cell_id' => $cell->id,
                ]);
            }
        }
    }
}