<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'bio',
        'education',
        'education_year',
        'interests',
        'experience',
        'email',
        'github_url',
        'linkedin_url',
        'instagram_url',
        'other_social_name',
        'other_social_url',
        'photo',
        'hero_headline',
        'hero_description',
        'about_extra',
    ];

    /**
     * Get the first (and only) profile, or create a placeholder.
     */
    public static function getInstance(): static
    {
        return static::firstOrNew(['id' => 1]);
    }
}
