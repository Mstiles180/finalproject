<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Sector;
use App\Models\Cell;
use App\Models\Village;
use App\Models\District;

echo "Updating administrative data with real Rwandan names...\n";

// Clear existing data
echo "Clearing existing data...\n";
Village::query()->delete();
Cell::query()->delete();
Sector::query()->delete();

// Get districts
$districts = District::all();
echo "Found " . $districts->count() . " districts\n";

// Create sectors for major districts
$sectorData = [
    'Gasabo' => ['Gisozi', 'Kacyiru', 'Kimihurura', 'Kimironko', 'Kinyinya', 'Ndera', 'Nduba', 'Remera', 'Rusororo', 'Rutunga'],
    'Kicukiro' => ['Gatenga', 'Gikondo', 'Kagarama', 'Kanombe', 'Kicukiro', 'Kigarama', 'Masaka', 'Niboye', 'Nyarugunga'],
    'Nyarugenge' => ['Gitega', 'Kanyinya', 'Kigali', 'Kimisagara', 'Mageragere', 'Muhima', 'Nyakabanda', 'Nyamirambo', 'Nyarugenge', 'Rwezamenyo'],
    'Huye' => ['Gishamvu', 'Karama', 'Kigoma', 'Kinazi', 'Mukura', 'Ngoma', 'Ruhashya', 'Rusatira', 'Rwaniro', 'Simbi'],
    'Muhanga' => ['Cyeza', 'Kibangu', 'Kiyumba', 'Muhanga', 'Munyinya', 'Musezero', 'Nyabinoni', 'Nyamabuye', 'Nyarusange', 'Rongi']
];

foreach ($sectorData as $districtName => $sectors) {
    $district = District::where('name', $districtName)->first();
    if ($district) {
        echo "Creating sectors for {$districtName}...\n";
        foreach ($sectors as $index => $sectorName) {
            Sector::create([
                'name' => $sectorName,
                'code' => $district->code . '-S' . ($index + 1),
                'district_id' => $district->id,
            ]);
        }
    }
}

// Create cells for some sectors
$cellData = [
    'Gisozi' => ['Gisozi', 'Kinyana', 'Nyarutarama'],
    'Kacyiru' => ['Kacyiru', 'Kagugu', 'Rukiri I', 'Rukiri II'],
    'Kimihurura' => ['Kimihurura', 'Kiyovu', 'Rugando'],
    'Gatenga' => ['Gatenga', 'Kagunga', 'Kamashashi'],
    'Gikondo' => ['Gikondo', 'Kigarama', 'Masaka'],
    'Gitega' => ['Gitega', 'Kanyinya', 'Kigali'],
    'Kanyinya' => ['Kanyinya', 'Kimisagara', 'Mageragere'],
    'Gishamvu' => ['Gishamvu', 'Karama', 'Kigoma'],
    'Karama' => ['Karama', 'Kinazi', 'Mukura'],
    'Cyeza' => ['Cyeza', 'Kibangu', 'Kiyumba'],
    'Kibangu' => ['Kibangu', 'Muhanga', 'Munyinya']
];

foreach ($cellData as $sectorName => $cells) {
    $sector = Sector::where('name', $sectorName)->first();
    if ($sector) {
        echo "Creating cells for {$sectorName}...\n";
        foreach ($cells as $index => $cellName) {
            Cell::create([
                'name' => $cellName,
                'code' => $sector->code . '-C' . ($index + 1),
                'sector_id' => $sector->id,
            ]);
        }
    }
}

// Create villages for some cells
$villageData = [
    'Gisozi' => ['Gisozi I', 'Gisozi II', 'Kinyana I', 'Kinyana II', 'Nyarutarama I', 'Nyarutarama II'],
    'Kacyiru' => ['Kacyiru I', 'Kacyiru II', 'Kagugu I', 'Kagugu II', 'Rukiri I', 'Rukiri II'],
    'Kimihurura' => ['Kimihurura I', 'Kimihurura II', 'Kiyovu I', 'Kiyovu II', 'Rugando I', 'Rugando II'],
    'Gatenga' => ['Gatenga I', 'Gatenga II', 'Kagunga I', 'Kagunga II', 'Kamashashi I', 'Kamashashi II'],
    'Gikondo' => ['Gikondo I', 'Gikondo II', 'Kigarama I', 'Kigarama II', 'Masaka I', 'Masaka II'],
    'Gitega' => ['Gitega I', 'Gitega II', 'Kanyinya I', 'Kanyinya II', 'Kigali I', 'Kigali II'],
    'Gishamvu' => ['Gishamvu I', 'Gishamvu II', 'Karama I', 'Karama II', 'Kigoma I', 'Kigoma II'],
    'Cyeza' => ['Cyeza I', 'Cyeza II', 'Kibangu I', 'Kibangu II', 'Kiyumba I', 'Kiyumba II']
];

foreach ($villageData as $cellName => $villages) {
    $cell = Cell::where('name', $cellName)->first();
    if ($cell) {
        echo "Creating villages for {$cellName}...\n";
        foreach ($villages as $index => $villageName) {
            Village::create([
                'name' => $villageName,
                'code' => $cell->code . '-V' . ($index + 1),
                'cell_id' => $cell->id,
            ]);
        }
    }
}

echo "Data update completed!\n";
echo "Sectors: " . Sector::count() . "\n";
echo "Cells: " . Cell::count() . "\n";
echo "Villages: " . Village::count() . "\n";
