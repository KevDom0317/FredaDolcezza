<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Mostrar el menú principal con todas las categorías y productos
     */
    public function index()
    {
        $categories = Category::active()
            ->with(['products' => function($query) {
                $query->available();
            }])
            ->orderBy('name')
            ->get();

        return view('menu.index', compact('categories'));
    }

    /**
     * Mostrar productos por categoría
     */
    public function category($id)
    {
        $category = Category::active()->findOrFail($id);
        $products = Product::available()
            ->where('category_id', $id)
            ->orderBy('name')
            ->get();

        return view('menu.category', compact('category', 'products'));
    }

    /**
     * Mostrar detalle de un producto
     */
    public function show($id)
    {
        $product = Product::available()
            ->with('category')
            ->findOrFail($id);

        return view('menu.show', compact('product'));
    }
}
