<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Updating database from hourly rates to daily rates...\n";

try {
    // Check if hourly_rate column exists in users table
    if (Schema::hasColumn('users', 'hourly_rate')) {
        echo "Renaming hourly_rate to daily_rate in users table...\n";
        DB::statement('ALTER TABLE users CHANGE hourly_rate daily_rate DECIMAL(8,2) NULL');
        echo "✓ Users table updated\n";
    } else {
        echo "Users table already has daily_rate column\n";
    }

    // Check if hourly_rate column exists in jobs table
    if (Schema::hasColumn('jobs', 'hourly_rate')) {
        echo "Renaming hourly_rate to daily_rate in jobs table...\n";
        DB::statement('ALTER TABLE jobs CHANGE hourly_rate daily_rate DECIMAL(8,2) NOT NULL');
        echo "✓ Jobs table updated\n";
    } else {
        echo "Jobs table already has daily_rate column\n";
    }

    echo "\n✅ Database update completed successfully!\n";
    echo "All hourly_rate columns have been renamed to daily_rate\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
