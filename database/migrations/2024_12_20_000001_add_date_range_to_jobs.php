<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, add the new columns as nullable
        Schema::table('jobs', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('location');
            $table->date('end_date')->nullable()->after('start_date');
            $table->integer('duration_days')->default(1)->after('end_date');
            $table->text('work_schedule')->nullable()->after('duration_days');
        });

        // Update existing records with valid dates
        DB::statement("
            UPDATE jobs 
            SET 
                start_date = CASE 
                    WHEN date IS NULL OR date = '0000-00-00' THEN CURDATE()
                    ELSE date 
                END,
                end_date = CASE 
                    WHEN date IS NULL OR date = '0000-00-00' THEN CURDATE()
                    ELSE date 
                END,
                duration_days = 1
        ");

        // Now make the columns not nullable
        Schema::table('jobs', function (Blueprint $table) {
            $table->date('start_date')->nullable(false)->change();
            $table->date('end_date')->nullable(false)->change();
        });

        // Drop the old date column
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }

    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Restore old structure
            $table->date('date')->after('location');
            
            // Drop new columns
            $table->dropColumn(['start_date', 'end_date', 'duration_days', 'work_schedule']);
        });
    }
};
