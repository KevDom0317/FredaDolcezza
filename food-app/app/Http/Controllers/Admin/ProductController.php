<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Búsqueda por nombre
        if ($request->has('search') && $request->search !== '') {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Búsqueda por descripción
        if ($request->has('description_search') && $request->description_search !== '') {
            $query->where('description', 'like', "%{$request->description_search}%");
        }

        // Filtro por categoría (por nombre de categoría)
        if ($request->has('category_search') && $request->category_search !== '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->category_search}%");
            });
        } elseif ($request->has('category') && $request->category !== '') {
            $query->where('category_id', $request->category);
        }

        // Filtro por estado
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_available', $request->status);
        }

        // Ordenamiento
        if ($request->has('sort')) {
            $direction = $request->get('direction', 'asc');
            switch($request->sort) {
                case 'name':
                    $query->orderBy('name', $direction);
                    break;
                case 'category':
                    $query->join('categories', 'products.category_id', '=', 'categories.id')
                          ->orderBy('categories.name', $direction)
                          ->select('products.*');
                    break;
                case 'is_available':
                    $query->orderBy('is_available', $direction);
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(20)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // Manejar la imagen si se subió
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Asegurar que is_available sea boolean
        $data['is_available'] = $request->has('is_available') ? true : false;

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Manejar la imagen si se subió una nueva
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Asegurar que is_available sea boolean
        $data['is_available'] = $request->has('is_available') ? true : false;

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Eliminar la imagen si existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
