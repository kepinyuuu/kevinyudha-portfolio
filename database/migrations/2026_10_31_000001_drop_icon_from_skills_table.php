<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Drop the unused `icon` column from the skills table.
 * The column was added in the original migration but no UI or
 * display logic was ever built for it (see audit 2026-10-31).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('level');
        });
    }
};

