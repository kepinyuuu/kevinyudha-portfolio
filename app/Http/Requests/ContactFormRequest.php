<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:100'],
            'email'   => ['required', 'email', 'max:100'],
            'subject' => ['required', 'string', 'min:3', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'website' => ['nullable', 'string'], // honeypot field checked in controller
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Nama wajib diisi.',
            'name.min'         => 'Nama minimal 2 karakter.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'subject.min'      => 'Subjek minimal 3 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min'      => 'Pesan minimal 10 karakter.',
        ];
    }
}
