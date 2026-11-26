<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'regex:/^(\+?62|0)[0-9]{8,13}$/'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'phone' => 'nomor telepon',
            'subject' => 'subjek',
            'message' => 'pesan',
        ];
    }

    public function messages(): array
    {
        return ['phone.regex' => 'Format nomor telepon tidak valid (contoh: 081234567890).'];
    }
}
