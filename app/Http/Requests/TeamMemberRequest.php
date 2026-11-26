<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:100'],
            'role'  => ['required', 'string', 'max:100'],
            'bio'   => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'  => 'nama',
            'role'  => 'peran',
            'bio'   => 'bio',
            'photo' => 'URL foto',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'max'      => ':attribute maksimal :max karakter.',
            'url'      => ':attribute harus berupa URL yang valid.',
        ];
    }
}
