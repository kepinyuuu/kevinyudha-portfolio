<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignWorkRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $imageRequired = $this->isMethod('POST') ? 'required' : 'nullable';
        return [
            'title'        => ['required', 'string', 'max:200'],
            'category'     => ['required', 'string', 'max:100'],
            'image'        => [$imageRequired, 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description'  => ['nullable', 'string', 'max:500'],
            'is_published' => ['boolean'],
            'sort_order'   => ['integer', 'min:0'],
        ];
    }
}
