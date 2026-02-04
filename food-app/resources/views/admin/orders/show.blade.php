@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Pedido #') }}{{ $order->id }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                ← Volver a Pedidos
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Información del Pedido -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Información del Cliente -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Información del Cliente
                        </h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Nombre:</span> {{ $order->customer_name }}</p>
                            <p><span class="font-medium">Teléfono:</span> {{ $order->customer_phone }}</p>
                            @if($order->notes)
                                <p><span class="font-medium">Notas:</span> {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Items del Pedido -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Productos del Pedido
                        </h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center space-x-4 border-b dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                    @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">Sin imagen</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Cantidad: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900 dark:text-white">
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
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Estado del Pedido
                        </h3>

                        <div class="mb-6">
                            @if($order->status == 'pendiente')
                                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    Pendiente
                                </span>
                            @elseif($order->status == 'en_preparacion')
                                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    En Preparación
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Entregado
                                </span>
                            @endif
                        </div>

                        <!-- Cambiar Estado -->
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="mb-6">
                            @csrf
                            @method('PATCH')
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Cambiar Estado:
                            </label>
                            <select 
                                name="status" 
                                id="status"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 mb-2"
                            >
                                <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_preparacion" {{ $order->status == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                                <option value="entregado" {{ $order->status == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition-colors">
                                Actualizar Estado
                            </button>
                        </form>

                        <!-- Resumen -->
                        <div class="border-t dark:border-gray-700 pt-4">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                    <span class="text-gray-900 dark:text-white">${{ number_format($order->total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Envío:</span>
                                    <span class="text-gray-900 dark:text-white">Gratis</span>
                                </div>
                                <div class="border-t dark:border-gray-700 pt-2 mt-2">
                                    <div class="flex justify-between text-lg font-bold">
                                        <span class="text-gray-900 dark:text-white">Total:</span>
                                        <span class="text-gray-900 dark:text-white">${{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Adicional -->
                        <div class="mt-6 pt-6 border-t dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                <strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

