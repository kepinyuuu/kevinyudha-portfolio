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
            'name'    => ['required', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'email'   => ['required', 'string', 'email', 'max:100', 'not_regex:/[\r\n]/'],
            'subject' => ['required', 'string', 'max:150', 'not_regex:/[\r\n]/'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            'website' => ['nullable', 'prohibited'], // Honeypot anti-spam
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'name.max'           => 'Nama tidak boleh lebih dari 100 karakter.',
            'name.not_regex'     => 'Nama tidak boleh mengandung baris baru.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.max'          => 'Email tidak boleh lebih dari 100 karakter.',
            'email.not_regex'    => 'Email tidak boleh mengandung baris baru.',
            'subject.required'   => 'Subjek pesan wajib diisi.',
            'subject.max'        => 'Subjek tidak boleh lebih dari 150 karakter.',
            'subject.not_regex'  => 'Subjek tidak boleh mengandung baris baru.',
            'message.required'   => 'Pesan wajib diisi.',
            'message.min'        => 'Pesan minimal berisi 10 karakter.',
            'message.max'        => 'Pesan maksimal berisi 3000 karakter.',
            'website.prohibited' => 'Spam terdeteksi.',
        ];
    }
}
