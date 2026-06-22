<?php
// database/migrations/xxxx_add_location_to_reports_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Add these only if they don't already exist
            $table->decimal('latitude',  10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('accuracy', 8, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'department_id']);
        });
    }
};