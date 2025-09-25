<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AdministrativeDataImporter;
use Throwable;

class ImportAdministrativeData extends Command
{
    protected $signature = 'data:import-administrative {--fresh : Truncate existing administrative tables before import}';
    protected $description = 'Import Rwanda administrative data (provinces→villages) from external API';

    public function handle(AdministrativeDataImporter $importer)
    {
        try {
            if ($this->option('fresh')) {
                $this->truncateAdministrativeTables();
            }

            $this->info('Importing administrative data from API...');
            $importer->importAll();
            $this->info('Administrative data import completed successfully.');
            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Import failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    private function truncateAdministrativeTables(): void
    {
        $this->info('Truncating villages, cells, sectors, districts, and provinces...');
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\Village::truncate();
        \App\Models\Cell::truncate();
        \App\Models\Sector::truncate();
        \App\Models\District::truncate();
        \App\Models\Province::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}


