<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('worker_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->timestamps();
            
            // Prevent duplicate offers
            $table->unique(['job_id', 'worker_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_offers');
    }
}; 