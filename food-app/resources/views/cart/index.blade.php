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
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --teal-dark: #345b63;
            --teal-medium: #4a7c8a;
            --teal-light: #7fb3c3;
            --teal-pastel: #b8d4dc;
        }
        .font-dancing {
            font-family: 'Dancing Script', cursive;
        }
        .bg-teal-gradient {
            background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal-medium) 50%, var(--teal-light) 100%);
        }
        .text-teal-dark { color: var(--teal-dark); }
        .text-teal-medium { color: var(--teal-medium); }
        .bg-teal-dark { background-color: var(--teal-dark); }
        .bg-teal-medium { background-color: var(--teal-medium); }
        .bg-teal-light { background-color: var(--teal-light); }
        .border-teal-light { border-color: var(--teal-light); }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Fondo con gradiente -->
    <div class="fixed inset-0 z-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#b8d4dc] via-[#7fb3c3] to-[#4a7c8a] opacity-50"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iYSIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIyIiBmaWxsPSIjMzQ1YjYzIiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNhKSIvPjwvc3ZnPg==')] opacity-20"></div>
    </div>

    <div class="relative z-10 min-h-screen">
        <!-- Header -->
        <header class="relative bg-white/90 backdrop-blur-sm shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-teal-dark">Carrito de Compras</h1>
                    <div class="flex space-x-4">
                        <a href="{{ route('menu.index') }}" class="text-gray-700 hover:text-teal-dark transition-colors font-medium">
                            Continuar Comprando
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-teal-dark transition-colors text-sm font-medium">
                                Panel
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @endif

            @if (session('error'))
                <x-alert type="error">{{ session('error') }}</x-alert>
            @endif

            @if(count($items) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Lista de productos -->
                    <div class="lg:col-span-2">
                        <div class="bg-white/95 backdrop-blur-sm rounded-lg shadow-xl border-2 border-teal-light overflow-hidden">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-teal-dark mb-4">
                                    Productos en el Carrito
                                </h2>
                                
                                <div class="space-y-4">
                                    @foreach($items as $item)
                                        <div class="flex items-center space-x-4 border-b border-teal-pastel pb-4 last:border-0 last:pb-0">
                                            <!-- Imagen -->
                                            <div class="flex-shrink-0">
                                                @if($item['product']->image)
                                                    <img src="{{ Storage::url($item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-20 h-20 object-contain rounded bg-teal-pastel p-1">
                                                @else
                                                    <div class="w-20 h-20 bg-teal-pastel rounded flex items-center justify-center">
                                                        <span class="text-teal-medium text-xs">Sin imagen</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Información del producto -->
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold text-gray-900">
                                                    {{ $item['product']->name }}
                                                </h3>
                                                <p class="text-gray-600 text-sm">
                                                    {{ $item['product']->category->name }}
                                                </p>
                                                <p class="text-teal-dark font-semibold mt-1">
                                                    ${{ number_format($item['price'], 2) }}
                                                </p>
                                            </div>

                                            <!-- Cantidad y acciones -->
                                            <div class="flex items-center space-x-4">
                                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    <label for="quantity-{{ $item['product']->id }}" class="text-sm text-gray-600">Cantidad:</label>
                                                    <input 
                                                        type="number" 
                                                        id="quantity-{{ $item['product']->id }}"
                                                        name="quantity" 
                                                        value="{{ $item['quantity'] }}" 
                                                        min="1" 
                                                        class="w-16 px-2 py-1 border border-teal-light rounded text-center focus:border-teal-medium focus:ring-teal-light"
                                                        onchange="this.form.submit()"
                                                    >
                                                </form>

                                                <div class="text-right">
                                                    <p class="text-lg font-bold text-teal-dark">
                                                        ${{ number_format($item['subtotal'], 2) }}
                                                    </p>
                                                </div>

                                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Eliminar">
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
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm transition-colors">
                                            Vaciar Carrito
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen -->
                    <div class="lg:col-span-1">
                        <div class="bg-white/95 backdrop-blur-sm rounded-lg shadow-xl border-2 border-teal-light p-6 sticky top-4">
                            <h2 class="text-xl font-semibold text-teal-dark mb-4">
                                Resumen del Pedido
                            </h2>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Envío:</span>
                                    <span>Gratis</span>
                                </div>
                                <div class="border-t border-teal-pastel pt-2 mt-2">
                                    <div class="flex justify-between text-lg font-bold text-teal-dark">
                                        <span>Total:</span>
                                        <span>${{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full bg-teal-gradient hover:opacity-90 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all shadow-md hover:shadow-lg">
                                Proceder al Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white/95 backdrop-blur-sm rounded-lg shadow-xl border-2 border-teal-light p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-teal-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-semibold text-gray-900">Tu carrito está vacío</h3>
                    <p class="mt-1 text-gray-500">Agrega productos al carrito para continuar</p>
                    <div class="mt-6">
                        <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-teal-gradient hover:opacity-90 text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg">
                            Ver Menú
                        </a>
                    </div>
                </div>
            @endif
        </main>
    </div>
</body>
</html>
