<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Mostrar lista de pedidos
     */
    public function index(Request $request)
    {
        $query = Order::with('items.product')->latest();

        // Búsqueda por nombre de cliente o teléfono
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Mostrar detalle de un pedido
     */
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Actualizar el estado de un pedido
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pendiente,en_preparacion,entregado',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Estado del pedido actualizado exitosamente');
    }
}




