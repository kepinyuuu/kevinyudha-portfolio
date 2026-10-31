<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
        'level',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'level'        => 'integer',
        'sort_order'   => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('name');
    }
}
