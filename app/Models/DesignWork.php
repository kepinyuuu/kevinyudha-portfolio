<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DesignWork extends Model
{
    protected $fillable = [
        'title',
        'category',
        'image',
        'description',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk(config('filesystems.default'))->url($this->image) : null;
    }
}
