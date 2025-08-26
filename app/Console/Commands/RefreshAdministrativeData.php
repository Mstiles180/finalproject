<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sector;
use App\Models\Cell;
use App\Models\Village;

class RefreshAdministrativeData extends Command
{
    protected $signature = 'data:refresh-administrative';
    protected $description = 'Refresh administrative data with better names';

    public function handle()
    {
        $this->info('Refreshing administrative data with better names...');

        // Clear existing data in correct order (respecting foreign keys)
        $this->info('Clearing existing villages...');
        Village::query()->delete();
        
        $this->info('Clearing existing cells...');
        Cell::query()->delete();
        
        $this->info('Clearing existing sectors...');
        Sector::query()->delete();

        // Reseed with better names
        $this->info('Seeding sectors with better names...');
        $this->call('db:seed', ['--class' => 'SectorSeeder']);

        $this->info('Seeding cells with better names...');
        $this->call('db:seed', ['--class' => 'CellSeeder']);

        $this->info('Seeding villages with better names...');
        $this->call('db:seed', ['--class' => 'VillageSeeder']);

        $this->info('Administrative data refreshed successfully!');
        
        // Show sample data
        $this->info("\nSample data:");
        $this->info("Sectors: " . Sector::count());
        $this->info("Cells: " . Cell::count());
        $this->info("Villages: " . Village::count());
        
        $this->info("\nSample sectors:");
        Sector::take(3)->get()->each(function($sector) {
            $this->info("- {$sector->name} (District: {$sector->district->name})");
        });
    }
}
