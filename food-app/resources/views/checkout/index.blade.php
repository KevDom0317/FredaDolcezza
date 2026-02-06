@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Finalizar Pedido</h1>
                    <a href="{{ route('cart.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        ← Volver al Carrito
                    </a>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Formulario -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            Información de Contacto
                        </h2>

                        <form method="POST" action="{{ route('checkout.store') }}">
                            @csrf

                            <!-- Nombre -->
                            <div class="mb-4">
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_name"
                                    name="customer_name" 
                                    value="{{ old('customer_name') }}" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: Juan Pérez"
                                >
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div class="mb-4">
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Teléfono <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="customer_phone"
                                    name="customer_phone" 
                                    value="{{ old('customer_phone') }}" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: 555-1234-5678"
                                >
                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notas -->
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Notas Adicionales (Opcional)
                                </label>
                                <textarea 
                                    id="notes"
                                    name="notes" 
                                    rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Instrucciones especiales, dirección de entrega, etc."
                                >{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                                Confirmar Pedido
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            Resumen del Pedido
                        </h2>
                        
                        <div class="space-y-3 mb-4">
                            @foreach($items as $item)
                                <div class="flex justify-between items-start border-b dark:border-gray-700 pb-3">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item['product']->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Cantidad: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}
                                        </p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        ${{ number_format($item['subtotal'], 2) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t dark:border-gray-700 pt-4 mt-4">
                            <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                                <span>Total:</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>



