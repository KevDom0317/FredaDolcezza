<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * Mostrar el estado de un pedido
     */
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('order.status', compact('order'));
    }
}





