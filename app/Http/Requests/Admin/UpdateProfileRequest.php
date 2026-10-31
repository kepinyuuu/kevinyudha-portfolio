<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:150'],
            'title'             => ['required', 'string', 'max:150'],
            'hero_headline'     => ['nullable', 'string', 'max:200'],
            'hero_description'  => ['nullable', 'string', 'max:500'],
            'bio'               => ['nullable', 'string'],
            'education'         => ['nullable', 'string', 'max:255'],
            'education_year'    => ['nullable', 'string', 'max:50'],
            'interests'         => ['nullable', 'string', 'max:500'],
            'experience'        => ['nullable', 'string'],
            'email'             => ['nullable', 'email', 'max:200'],
            'github_url'        => ['nullable', 'url', 'max:500'],
            'linkedin_url'      => ['nullable', 'url', 'max:500'],
            'instagram_url'     => ['nullable', 'url', 'max:500'],
            'other_social_name' => ['nullable', 'string', 'max:50'],
            'other_social_url'  => ['nullable', 'url', 'max:500'],
            'photo'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'about_extra'       => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'photo.mimes' => 'Foto harus berformat jpg, jpeg, png, atau webp.',
            'photo.max'   => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}

