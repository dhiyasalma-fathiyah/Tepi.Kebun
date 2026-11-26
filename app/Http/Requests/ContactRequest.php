<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'name'       => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255'],
            'message'    => ['required', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'produk',
            'name'       => 'nama',
            'email'      => 'email',
            'message'    => 'pesan',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'email'    => 'Format :attribute tidak valid.',
            'max'      => ':attribute maksimal :max karakter.',
            'exists'   => ':attribute yang dipilih tidak ditemukan.',
        ];
    }
}
