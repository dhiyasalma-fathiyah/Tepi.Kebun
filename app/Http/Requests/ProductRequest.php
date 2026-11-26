<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'product_name' => ['required', 'string', 'max:100'],
            'grade' => ['required', 'in:A,B'],
            'ripeness_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'weight_per_box' => ['required', 'numeric', 'min:0.1', 'max:9999'],
            'price_per_box' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'kategori',
            'product_name' => 'nama produk',
            'grade' => 'grade',
            'ripeness_percentage' => 'tingkat kematangan',
            'weight_per_box' => 'berat per box',
            'price_per_box' => 'harga per box',
            'stock' => 'stok',
            'description' => 'deskripsi',
            'image' => 'foto',
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Foto harus berformat JPG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}
