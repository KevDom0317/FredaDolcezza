<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear usuario admin
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_products_list(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/products');

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
    }

    public function test_admin_can_create_product(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post('/admin/products', [
                'name' => 'Producto de Prueba',
                'description' => 'Descripción del producto',
                'price' => 25.50,
                'category_id' => $category->id,
                'is_available' => true,
            ]);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', [
            'name' => 'Producto de Prueba',
            'price' => 25.50,
        ]);
    }

    public function test_product_validation_requires_name(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post('/admin/products', [
                'description' => 'Descripción',
                'price' => 25.50,
                'category_id' => $category->id,
            ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_product_validation_requires_price(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post('/admin/products', [
                'name' => 'Producto',
                'category_id' => $category->id,
            ]);

        $response->assertSessionHasErrors(['price']);
    }

    public function test_admin_can_update_product(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($this->admin)
            ->put("/admin/products/{$product->id}", [
                'name' => 'Producto Actualizado',
                'description' => $product->description,
                'price' => 30.00,
                'category_id' => $category->id,
                'is_available' => true,
            ]);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Producto Actualizado',
            'price' => 30.00,
        ]);
    }

    public function test_admin_can_delete_product(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($this->admin)
            ->delete("/admin/products/{$product->id}");

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_products_can_be_searched(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create([
            'name' => 'Producto Especial',
            'category_id' => $category->id,
        ]);
        Product::factory()->create([
            'name' => 'Otro Producto',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/products?search=Especial');

        $response->assertStatus(200);
        $response->assertSee('Producto Especial');
        $response->assertDontSee('Otro Producto');
    }
}

