<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->text('bio');
            $table->string('education');
            $table->string('education_year')->nullable();
            $table->text('interests')->nullable();
            $table->text('experience')->nullable();
            $table->string('email');
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('other_social_name')->nullable();
            $table->string('other_social_url')->nullable();
            $table->string('photo')->nullable();
            $table->text('hero_headline')->nullable();
            $table->text('hero_description')->nullable();
            $table->text('about_extra')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
