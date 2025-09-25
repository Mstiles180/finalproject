<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nid_image_url')) {
                $table->string('nid_image_url')->nullable()->after('document_url');
            }
            if (!Schema::hasColumn('users', 'experience_image_url')) {
                $table->string('experience_image_url')->nullable()->after('nid_image_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nid_image_url')) {
                $table->dropColumn('nid_image_url');
            }
            if (Schema::hasColumn('users', 'experience_image_url')) {
                $table->dropColumn('experience_image_url');
            }
        });
    }
};


