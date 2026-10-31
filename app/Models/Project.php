<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'technologies',
        'image',
        'demo_url',
        'github_url',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function getTechnologiesArrayAttribute(): array
    {
        return array_map('trim', explode(',', $this->technologies));
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk(config('filesystems.default'))->url($this->image) : null;
    }
}
