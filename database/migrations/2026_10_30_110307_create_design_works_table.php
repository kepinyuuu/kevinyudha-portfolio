<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('design_works', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category'); // UI/UX, Graphic Design, Branding, Illustration, etc.
            $table->string('image');
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'category', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design_works');
    }
};
