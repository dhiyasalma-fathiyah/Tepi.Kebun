<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
        $this->get('/admin/products')->assertRedirect(route('login'));
    }

    public function test_non_admin_user_is_forbidden(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_login_and_view_dashboard(): void
    {
        $admin = User::factory()->create(['email' => 'boss@example.com', 'password' => 'secret123']);
        $admin->forceFill(['is_admin' => true])->save();

        $this->post('/login', ['email' => 'boss@example.com', 'password' => 'secret123'])
            ->assertRedirect(route('admin.dashboard'));

        $this->get('/admin')->assertOk();
    }

    public function test_admin_can_create_product_with_photo_and_soft_delete_it(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $category = Category::create(['name' => 'Tropis', 'slug' => 'tropis', 'icon' => '🍍']);

        $this->actingAs($admin)->post('/admin/products', [
            'category_id' => $category->id,
            'product_name' => 'Jambu Biji',
            'grade' => 'A',
            'ripeness_percentage' => 80,
            'weight_per_box' => 10,
            'price_per_box' => 150000,
            'stock' => 20,
            'image' => UploadedFile::fake()->image('jambu.jpg', 400, 400),
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::firstWhere('product_name', 'Jambu Biji');
        $this->assertNotNull($product);
        Storage::disk('public')->assertExists($product->image);

        $this->actingAs($admin)->delete("/admin/products/{$product->id}");
        $this->assertSoftDeleted($product);
    }

    public function test_product_photo_must_be_a_valid_image(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)->post('/admin/products', [
            'image' => UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf'),
        ])->assertSessionHasErrors(['image', 'product_name', 'category_id']);
    }
}
