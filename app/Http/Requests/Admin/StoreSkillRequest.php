<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:100'],
            'category'     => ['required', 'in:general,design,tools'],
            'level'        => ['required', 'integer', 'min:1', 'max:100'],
            'sort_order'   => ['integer', 'min:0'],
            'is_published' => ['boolean'],
        ];
    }
}
