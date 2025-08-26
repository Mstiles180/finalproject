<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add 'completed' to the status enum
        DB::statement("ALTER TABLE job_offers MODIFY COLUMN status ENUM('pending', 'accepted', 'declined', 'completed') DEFAULT 'pending'");
    }

    public function down()
    {
        // Remove 'completed' from the status enum
        DB::statement("ALTER TABLE job_offers MODIFY COLUMN status ENUM('pending', 'accepted', 'declined') DEFAULT 'pending'");
    }
};
