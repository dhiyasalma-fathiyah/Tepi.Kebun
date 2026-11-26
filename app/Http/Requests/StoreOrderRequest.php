<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'regex:/^(\+?62|0)[0-9]{8,13}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'min:10', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'digits:5'],
            'notes' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', Rule::in(array_keys(Order::PAYMENT_METHODS))],
            'items' => ['required', 'array'],
            'items.*' => ['nullable', 'integer', 'min:0', 'max:999'],
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_name' => 'nama pembeli',
            'phone' => 'nomor telepon',
            'email' => 'email',
            'address' => 'alamat lengkap',
            'city' => 'kota',
            'postal_code' => 'kode pos',
            'notes' => 'catatan',
            'payment_method' => 'metode pembayaran',
            'items' => 'produk',
            'items.*' => 'jumlah',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Format nomor telepon tidak valid (contoh: 081234567890).',
            'postal_code.digits' => 'Kode pos harus 5 digit angka.',
            'items.required' => 'Pilih minimal satu produk untuk dipesan.',
        ];
    }

    /**
     * Rekap jumlah per produk (product_id => qty), hanya yang qty > 0.
     * Memanfaatkan Laravel Collection.
     */
    public function quantities(): Collection
    {
        return collect($this->input('items', []))
            ->mapWithKeys(fn ($qty, $id) => [(int) $id => (int) $qty])
            ->filter(fn (int $qty) => $qty > 0);
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $quantities = $this->quantities();

            if ($quantities->isEmpty()) {
                $validator->errors()->add('items', 'Pilih minimal satu produk (jumlah minimal 1 box).');

                return;
            }

            $products = Product::whereIn('id', $quantities->keys())->get()->keyBy('id');

            $quantities->each(function (int $qty, int $id) use ($products, $validator) {
                $product = $products->get($id);

                if (! $product) {
                    $validator->errors()->add('items', 'Ada produk yang sudah tidak tersedia.');
                } elseif ($product->stock < $qty) {
                    $validator->errors()->add(
                        'items',
                        "Stok {$product->product_name} tersisa {$product->stock} box."
                    );
                }
            });
        }];
    }
}
