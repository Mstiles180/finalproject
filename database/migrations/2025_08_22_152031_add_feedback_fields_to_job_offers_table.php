<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->integer('rating')->nullable()->after('completed_at');
            $table->text('feedback')->nullable()->after('rating');
            $table->timestamp('feedback_at')->nullable()->after('feedback');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->dropColumn(['rating', 'feedback', 'feedback_at']);
        });
    }
};
