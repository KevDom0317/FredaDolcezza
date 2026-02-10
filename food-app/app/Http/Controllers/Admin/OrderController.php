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
        $query = Order::with('items.product');

        // Búsqueda por nombre de cliente
        if ($request->has('search') && $request->search !== '') {
            $query->where('customer_name', 'like', "%{$request->search}%");
        }

        // Búsqueda por teléfono
        if ($request->has('phone_search') && $request->phone_search !== '') {
            $query->where('customer_phone', 'like', "%{$request->phone_search}%");
        }

        // Filtro por estado
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Ordenamiento
        if ($request->has('sort')) {
            $direction = $request->get('direction', 'asc');
            switch($request->sort) {
                case 'customer_name':
                    $query->orderBy('customer_name', $direction);
                    break;
                case 'total':
                    $query->orderBy('total', $direction);
                    break;
                case 'status':
                    $query->orderBy('status', $direction);
                    break;
                case 'created_at':
                    $query->orderBy('created_at', $direction);
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $orders = $query->paginate(20)->withQueryString();

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




