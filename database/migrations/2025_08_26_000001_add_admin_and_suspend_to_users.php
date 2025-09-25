<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add is_suspended flag
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_suspended')) {
                $table->boolean('is_suspended')->default(false)->after('remember_token');
            }
        });

        // Extend enum for role to include admin (MySQL enum alteration via raw statement)
        // Note: ensure your DB is MySQL-compatible. Adjust if using a different driver.
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('worker','boss','admin') NOT NULL DEFAULT 'worker'");
        } catch (\Throwable $e) {
            // Fallback: if enum modification fails (e.g., SQLite), ignore.
        }
    }

    public function down(): void
    {
        // Remove is_suspended
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_suspended')) {
                $table->dropColumn('is_suspended');
            }
        });

        // Attempt to revert enum to original
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('worker','boss') NOT NULL DEFAULT 'worker'");
        } catch (\Throwable $e) {
            // ignore
        }
    }
};


