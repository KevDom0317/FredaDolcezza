@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Detalle del Pedido')

@php
    $pageTitle = 'Detalle del Pedido #' . $order->id;
    $breadcrumbs = [
        ['label' => 'Pedidos', 'url' => route('admin.orders.index')],
        ['label' => 'Detalle']
    ];
@endphp

@section('header-actions')
<a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-medium">
    ← Volver a Pedidos
</a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Información del Pedido -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Información del Cliente -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Información del Cliente
            </h3>
            <div class="space-y-2">
                <p><span class="font-medium text-gray-700">Nombre:</span> <span class="text-gray-900">{{ $order->customer_name }}</span></p>
                <p><span class="font-medium text-gray-700">Teléfono:</span> <span class="text-gray-900">{{ $order->customer_phone }}</span></p>
                @if($order->notes)
                    <p><span class="font-medium text-gray-700">Notas:</span> <span class="text-gray-900">{{ $order->notes }}</span></p>
                @endif
            </div>
        </div>

        <!-- Items del Pedido -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Productos del Pedido
            </h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center space-x-4 border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                        @if($item->product->image)
                            <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-contain rounded bg-gray-100 p-1">
                        @else
                            <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Sin imagen</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-500">
                                Cantidad: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-teal-dark">
                                ${{ number_format($item->quantity * $item->price, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Panel Lateral -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 sticky top-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Estado del Pedido
            </h3>

            <div class="mb-6">
                @if($order->status == 'pendiente')
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Pendiente
                    </span>
                @elseif($order->status == 'en_preparacion')
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        En Preparación
                    </span>
                @else
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        Entregado
                    </span>
                @endif
            </div>

            <!-- Cambiar Estado -->
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="mb-6">
                @csrf
                @method('PATCH')
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Cambiar Estado:
                </label>
                <select 
                    name="status" 
                    id="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-medium focus:border-teal-medium mb-2"
                >
                    <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_preparacion" {{ $order->status == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                    <option value="entregado" {{ $order->status == 'entregado' ? 'selected' : '' }}>Entregado</option>
                </select>
                <button type="submit" class="w-full bg-teal-gradient hover:opacity-90 text-white font-semibold py-2 px-4 rounded-md transition-all shadow-md hover:shadow-lg">
                    Actualizar Estado
                </button>
            </form>

            <!-- Resumen -->
            <div class="border-t border-gray-200 pt-4">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="text-teal-dark font-semibold">${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Envío:</span>
                        <span class="text-gray-700">Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="flex justify-between text-lg font-bold text-teal-dark">
                            <span>Total:</span>
                            <span>${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    <strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
