<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_user_can_create_order(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
            'price' => 15.50,
        ]);

        // Agregar producto al carrito
        $this->post("/cart/add/{$product->id}", ['quantity' => 2]);

        $response = $this->post('/checkout', [
            'customer_name' => 'Juan Pérez',
            'customer_phone' => '+1234567890',
            'notes' => 'Entregar antes de las 6pm',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Juan Pérez',
            'customer_phone' => '+1234567890',
            'total' => 31.00, // 15.50 * 2
            'status' => 'pendiente',
        ]);
    }

    public function test_order_validation_requires_customer_name(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
        ]);

        $this->post("/cart/add/{$product->id}");

        $response = $this->post('/checkout', [
            'customer_phone' => '+1234567890',
        ]);

        $response->assertSessionHasErrors(['customer_name']);
    }

    public function test_order_validation_requires_customer_phone(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_available' => true,
        ]);

        $this->post("/cart/add/{$product->id}");

        $response = $this->post('/checkout', [
            'customer_name' => 'Juan Pérez',
        ]);

        $response->assertSessionHasErrors(['customer_phone']);
    }

    public function test_admin_can_view_orders_list(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.index');
    }

    public function test_admin_can_update_order_status(): void
    {
        $order = Order::factory()->create(['status' => 'pendiente']);

        $response = $this->actingAs($this->admin)
            ->patch("/admin/orders/{$order->id}/status", [
                'status' => 'en_preparacion',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'en_preparacion',
        ]);
    }

    public function test_orders_can_be_searched(): void
    {
        Order::factory()->create(['customer_name' => 'Juan Pérez']);
        Order::factory()->create(['customer_name' => 'María García']);

        $response = $this->actingAs($this->admin)
            ->get('/admin/orders?search=Juan');

        $response->assertStatus(200);
        $response->assertSee('Juan Pérez');
        $response->assertDontSee('María García');
    }
}

