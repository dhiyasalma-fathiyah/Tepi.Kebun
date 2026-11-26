<?php

namespace Tests\Feature;

use App\Mail\ContactMessageMail;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderAndContactTest extends TestCase
{
    use RefreshDatabase;

    private function product(int $stock = 10): Product
    {
        $category = Category::create(['name' => 'Tropis', 'slug' => 'tropis', 'icon' => '🍍']);

        return Product::create([
            'category_id' => $category->id,
            'product_name' => 'Pisang Test',
            'slug' => 'pisang-test',
            'grade' => 'A',
            'ripeness_percentage' => 80,
            'weight_per_box' => 10,
            'price_per_box' => 100000,
            'stock' => $stock,
        ]);
    }

    private function orderPayload(Product $product, int $qty): array
    {
        return [
            'customer_name' => 'Budi',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 1, Bandung',
            'city' => 'Bandung',
            'postal_code' => '40111',
            'payment_method' => 'transfer',
            'items' => [$product->id => $qty],
        ];
    }

    public function test_order_is_saved_with_total_and_stock_is_reduced(): void
    {
        $product = $this->product(10);

        $response = $this->post('/pesan', $this->orderPayload($product, 3));

        $order = Order::first();
        $response->assertRedirect(route('orders.show', $order));
        $this->assertEquals(300000, $order->total_amount);
        $this->assertSame(1, $order->items()->count());
        $this->assertSame(7, $product->fresh()->stock);
        $this->get(route('orders.show', $order))->assertOk()->assertSee($order->order_code);
    }

    public function test_order_requires_valid_data_and_enough_stock(): void
    {
        $product = $this->product(2);

        $this->post('/pesan', ['items' => [$product->id => 0]])
            ->assertSessionHasErrors(['customer_name', 'phone', 'address', 'city', 'postal_code', 'payment_method']);

        $this->post('/pesan', $this->orderPayload($product, 5))->assertSessionHasErrors('items');
        $this->assertSame(0, Order::count());
    }

    public function test_contact_message_is_saved_and_emailed(): void
    {
        Mail::fake();

        $this->post('/contact-us', [
            'name' => 'Sari',
            'email' => 'sari@example.com',
            'subject' => 'Kerja sama',
            'message' => 'Saya ingin bekerja sama untuk pasokan buah.',
        ])->assertRedirect(route('contact'));

        $this->assertSame(1, Contact::count());
        Mail::assertSent(ContactMessageMail::class);
    }

    public function test_contact_still_saved_when_mail_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));

        $this->post('/contact-us', [
            'name' => 'Sari',
            'email' => 'sari@example.com',
            'subject' => 'Kerja sama',
            'message' => 'Saya ingin bekerja sama untuk pasokan buah.',
        ])->assertRedirect(route('contact'))->assertSessionHas('success');

        $this->assertSame(1, Contact::count());
    }
}
