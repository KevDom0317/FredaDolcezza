<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_to_cart(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
        ]);

        $response = $this->post("/cart/add/{$product->id}", [
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('cart');
        $this->assertArrayHasKey($product->id, session('cart'));
        $this->assertEquals(2, session("cart.{$product->id}.quantity"));
    }

    public function test_user_can_view_cart(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
        ]);

        $this->post("/cart/add/{$product->id}");

        $response = $this->get('/cart');

        $response->assertStatus(200);
        $response->assertViewIs('cart.index');
        $response->assertSee($product->name);
    }

    public function test_user_can_update_cart_item_quantity(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
        ]);

        $this->post("/cart/add/{$product->id}", ['quantity' => 1]);

        $response = $this->post("/cart/update/{$product->id}", [
            'quantity' => 5,
        ]);

        $response->assertRedirect('/cart');
        $this->assertEquals(5, session("cart.{$product->id}.quantity"));
    }

    public function test_user_can_remove_product_from_cart(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
        ]);

        $this->post("/cart/add/{$product->id}");

        $response = $this->delete("/cart/remove/{$product->id}");

        $response->assertRedirect('/cart');
        $this->assertArrayNotHasKey($product->id, session('cart', []));
    }

    public function test_user_cannot_add_unavailable_product(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_available' => false,
        ]);

        $response = $this->post("/cart/add/{$product->id}");

        $response->assertNotFound();
    }
}

