<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('bio')->nullable()->change();
            $table->string('education')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Tidak dikembalikan ke NOT NULL: baris yang sudah berisi null akan membuat rollback gagal.
    }
};