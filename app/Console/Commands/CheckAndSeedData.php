<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Province;
use App\Models\District;
use App\Models\Sector;
use App\Models\Cell;
use App\Models\Village;

class CheckAndSeedData extends Command
{
    protected $signature = 'data:check-and-seed';
    protected $description = 'Check and seed administrative data if needed';

    public function handle()
    {
        $this->info('Checking administrative data...');

        // Check provinces
        $provinceCount = Province::count();
        $this->info("Provinces: {$provinceCount}");

        if ($provinceCount === 0) {
            $this->info('Seeding provinces...');
            $this->call('db:seed', ['--class' => 'ProvinceSeeder']);
        }

        // Check districts
        $districtCount = District::count();
        $this->info("Districts: {$districtCount}");

        if ($districtCount === 0) {
            $this->info('Seeding districts...');
            $this->call('db:seed', ['--class' => 'DistrictSeeder']);
        }

        // Check sectors
        $sectorCount = Sector::count();
        $this->info("Sectors: {$sectorCount}");

        if ($sectorCount === 0) {
            $this->info('Seeding sectors...');
            $this->call('db:seed', ['--class' => 'SectorSeeder']);
        }

        // Check cells
        $cellCount = Cell::count();
        $this->info("Cells: {$cellCount}");

        if ($cellCount === 0) {
            $this->info('Seeding cells...');
            $this->call('db:seed', ['--class' => 'CellSeeder']);
        }

        // Check villages
        $villageCount = Village::count();
        $this->info("Villages: {$villageCount}");

        if ($villageCount === 0) {
            $this->info('Seeding villages...');
            $this->call('db:seed', ['--class' => 'VillageSeeder']);
        }

        $this->info('Data check complete!');
        
        // Show sample data
        $this->info("\nSample data:");
        $this->info("First province: " . Province::first()?->name ?? 'None');
        $this->info("First district: " . District::first()?->name ?? 'None');
        $this->info("First sector: " . Sector::first()?->name ?? 'None');
        $this->info("First cell: " . Cell::first()?->name ?? 'None');
        $this->info("First village: " . Village::first()?->name ?? 'None');
    }
}
