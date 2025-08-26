<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['laundry', 'builder', 'builder_helper', 'farmer', 'cleaner', 'other']);
            $table->string('other_category')->nullable();
            $table->string('location');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('hourly_rate', 8, 2);
            $table->enum('status', ['active', 'inactive', 'filled'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
