<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
    }

    public function test_public_pages_are_accessible(): void
    {
        $product = Product::first();

        foreach (['/', '/about', '/team', '/produk', "/produk/{$product->slug}", '/pesan', '/contact-us', '/login'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_catalog_can_be_filtered_with_collection(): void
    {
        $this->get('/produk?q=pisang')
            ->assertOk()
            ->assertSee('Pisang Cavendish')
            ->assertDontSee('Jeruk Siam');
    }
}
