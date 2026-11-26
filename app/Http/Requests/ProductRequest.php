<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_name'        => ['required', 'string', 'max:100'],
            'category'            => ['required', 'string', 'max:50'],
            'grade'               => ['required', 'in:A,B'],
            'ripeness_percentage' => ['required', 'integer', 'between:0,100'],
            'weight_per_box'      => ['required', 'numeric', 'min:0'],
            'price_per_box'       => ['required', 'numeric', 'min:0'],
            'stock'               => ['required', 'integer', 'min:0'],
            'description'         => ['nullable', 'string', 'max:2000'],
            'image'               => ['nullable', 'url', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_name'        => 'nama produk',
            'category'            => 'kategori',
            'grade'               => 'grade',
            'ripeness_percentage' => 'tingkat kematangan',
            'weight_per_box'      => 'berat per box',
            'price_per_box'       => 'harga per box',
            'stock'               => 'stok',
            'description'         => 'deskripsi',
            'image'               => 'URL gambar',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'max'      => ':attribute maksimal :max karakter/nilai.',
            'in'       => ':attribute harus A atau B.',
            'integer'  => ':attribute harus berupa bilangan bulat.',
            'numeric'  => ':attribute harus berupa angka.',
            'min'      => ':attribute minimal :min.',
            'between'  => ':attribute harus antara :min sampai :max.',
            'url'      => ':attribute harus berupa URL yang valid.',
        ];
    }
}
