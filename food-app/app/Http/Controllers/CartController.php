<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Mostrar el contenido del carrito
     */
    public function index()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product && $product->is_available) {
                $subtotal = $item['quantity'] * $item['price'];
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Agregar un producto al carrito
     */
    public function add(Request $request, $productId)
    {
        $product = Product::available()->findOrFail($productId);
        
        $cart = session('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->input('quantity', 1);
        } else {
            $cart[$productId] = [
                'quantity' => $request->input('quantity', 1),
                'price' => $product->price,
                'name' => $product->name,
                'image' => $product->image,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    /**
     * Actualizar la cantidad de un producto en el carrito
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->input('quantity');
            session(['cart' => $cart]);
            
            return redirect()->route('cart.index')->with('success', 'Cantidad actualizada');
        }

        return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito');
    }

    /**
     * Eliminar un producto del carrito
     */
    public function remove($productId)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
            
            return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito');
        }

        return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito');
    }

    /**
     * Vaciar el carrito
     */
    public function clear()
    {
        session(['cart' => []]);
        
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado');
    }
}
