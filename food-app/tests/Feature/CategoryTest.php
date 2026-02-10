<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_categories_list(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/categories');

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.index');
    }

    public function test_admin_can_create_category(): void
    {
        $response = $this->actingAs($this->admin)
            ->post('/admin/categories', [
                'name' => 'Categoría de Prueba',
                'description' => 'Descripción de la categoría',
                'is_active' => true,
            ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'Categoría de Prueba',
        ]);
    }

    public function test_category_validation_requires_name(): void
    {
        $response = $this->actingAs($this->admin)
            ->post('/admin/categories', [
                'description' => 'Descripción',
            ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_category_name_must_be_unique(): void
    {
        $category = Category::factory()->create(['name' => 'Categoría Única']);

        $response = $this->actingAs($this->admin)
            ->post('/admin/categories', [
                'name' => 'Categoría Única',
                'description' => 'Descripción',
            ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_admin_can_update_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put("/admin/categories/{$category->id}", [
                'name' => 'Categoría Actualizada',
                'description' => $category->description,
                'is_active' => true,
            ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Categoría Actualizada',
        ]);
    }

    public function test_admin_can_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete("/admin/categories/{$category->id}");

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}

