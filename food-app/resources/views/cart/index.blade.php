@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Carrito de Compras - {{ config('app.name', 'Laravel') }}</title>
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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Carrito de Compras</h1>
                    <div class="flex space-x-4">
                        <a href="{{ route('menu.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            Continuar Comprando
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                Panel Admin
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if(count($items) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Lista de productos -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                    Productos en el Carrito
                                </h2>
                                
                                <div class="space-y-4">
                                    @foreach($items as $item)
                                        <div class="flex items-center space-x-4 border-b dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                            <!-- Imagen -->
                                            <div class="flex-shrink-0">
                                                @if($item['product']->image)
                                                    <img src="{{ Storage::url($item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-20 h-20 object-cover rounded">
                                                @else
                                                    <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                                        <span class="text-gray-400 text-xs">Sin imagen</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Información del producto -->
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    {{ $item['product']->name }}
                                                </h3>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $item['product']->category->name }}
                                                </p>
                                                <p class="text-indigo-600 dark:text-indigo-400 font-semibold mt-1">
                                                    ${{ number_format($item['price'], 2) }}
                                                </p>
                                            </div>

                                            <!-- Cantidad y acciones -->
                                            <div class="flex items-center space-x-4">
                                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    <label for="quantity-{{ $item['product']->id }}" class="text-sm text-gray-600 dark:text-gray-400">Cantidad:</label>
                                                    <input 
                                                        type="number" 
                                                        id="quantity-{{ $item['product']->id }}"
                                                        name="quantity" 
                                                        value="{{ $item['quantity'] }}" 
                                                        min="1" 
                                                        class="w-16 px-2 py-1 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded text-center"
                                                        onchange="this.form.submit()"
                                                    >
                                                </form>

                                                <div class="text-right">
                                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                                        ${{ number_format($item['subtotal'], 2) }}
                                                    </p>
                                                </div>

                                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Eliminar">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Botón para vaciar carrito -->
                                <div class="mt-6">
                                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('¿Estás seguro de vaciar el carrito?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">
                                            Vaciar Carrito
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                Resumen del Pedido
                            </h2>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Envío:</span>
                                    <span>Gratis</span>
                                </div>
                                <div class="border-t dark:border-gray-700 pt-2 mt-2">
                                    <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                                        <span>Total:</span>
                                        <span>${{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition-colors">
                                Proceder al Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">Tu carrito está vacío</h3>
                    <p class="mt-1 text-gray-500 dark:text-gray-400">Agrega productos al carrito para continuar</p>
                    <div class="mt-6">
                        <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                            Ver Menú
                        </a>
                    </div>
                </div>
            @endif
        </main>
    </div>
</body>
</html>

