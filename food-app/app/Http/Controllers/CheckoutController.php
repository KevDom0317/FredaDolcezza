<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Mostrar el formulario de checkout
     */
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = \App\Models\Product::find($productId);
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

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'No hay productos disponibles en tu carrito');
        }

        return view('checkout.index', compact('items', 'total'));
    }

    /**
     * Procesar el pedido
     */
    public function store(StoreOrderRequest $request)
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        // Calcular total
        $total = 0;
        $items = [];
        
        foreach ($cart as $productId => $item) {
            $product = \App\Models\Product::find($productId);
            if ($product && $product->is_available) {
                $subtotal = $item['quantity'] * $item['price'];
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ];
                $total += $subtotal;
            }
        }

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'No hay productos disponibles en tu carrito');
        }

        // Crear el pedido
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'total' => $total,
            'status' => 'pendiente',
            'notes' => $request->notes,
        ]);

        // Crear los items del pedido
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Limpiar el carrito
        session(['cart' => []]);

        return redirect()->route('order.status', $order->id)
            ->with('success', '¡Pedido realizado exitosamente! Tu número de pedido es #' . $order->id);
    }
}

