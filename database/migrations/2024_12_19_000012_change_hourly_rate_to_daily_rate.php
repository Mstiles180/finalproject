<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Change hourly_rate to daily_rate in users table
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('hourly_rate', 'daily_rate');
        });

        // Change hourly_rate to daily_rate in jobs table
        Schema::table('jobs', function (Blueprint $table) {
            $table->renameColumn('hourly_rate', 'daily_rate');
        });
    }

    public function down()
    {
        // Revert changes in users table
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('daily_rate', 'hourly_rate');
        });

        // Revert changes in jobs table
        Schema::table('jobs', function (Blueprint $table) {
            $table->renameColumn('daily_rate', 'hourly_rate');
        });
    }
};
