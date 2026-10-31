<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:200'],
            'description'  => ['required', 'string'],
            'technologies' => ['required', 'string', 'max:500'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'demo_url'     => ['nullable', 'url', 'max:500'],
            'github_url'   => ['nullable', 'url', 'max:500'],
            'is_featured'  => ['boolean'],
            'is_published' => ['boolean'],
            'sort_order'   => ['integer', 'min:0'],
        ];
    }
}
