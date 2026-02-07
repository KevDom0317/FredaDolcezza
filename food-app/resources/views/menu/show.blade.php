@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - {{ config('app.name', 'Laravel') }}</title>
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
                    <a href="{{ route('menu.index') }}" class="text-teal-dark hover:text-teal-medium font-medium transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Menú
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-teal-dark transition-colors text-sm font-medium">
                            Panel
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white/95 backdrop-blur-sm rounded-lg shadow-xl border-2 border-teal-light overflow-hidden">
                <div class="md:flex">
                    <!-- Imagen -->
                    <div class="md:w-1/2">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain bg-gradient-to-br from-[#b8d4dc] to-[#7fb3c3]">
                        @else
                            <div class="w-full h-64 md:h-full bg-gradient-to-br from-[#b8d4dc] to-[#7fb3c3] flex items-center justify-center">
                                <svg class="w-24 h-24 text-teal-medium opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Información -->
                    <div class="md:w-1/2 p-8">
                        <div class="mb-4">
                            <span class="inline-block bg-teal-pastel text-teal-dark text-sm font-semibold px-3 py-1 rounded-full border border-teal-light">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            {{ $product->name }}
                        </h1>

                        <div class="mb-6">
                            <span class="text-4xl font-bold text-teal-dark">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        </div>

                        @if($product->description)
                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-2">Descripción</h2>
                                <p class="text-gray-600">
                                    {{ $product->description }}
                                </p>
                            </div>
                        @endif

                        <div class="flex items-center space-x-4 mb-6">
                            @if($product->is_available)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    ✓ Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                    ✗ No disponible
                                </span>
                            @endif
                        </div>

                        <!-- Botón para agregar al carrito -->
                        @if($product->is_available)
                            <div class="mt-6">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                                    @csrf
                                    <div class="flex items-center space-x-4 mb-4">
                                        <label for="quantity" class="text-sm font-medium text-gray-700">Cantidad:</label>
                                        <input 
                                            type="number" 
                                            id="quantity"
                                            name="quantity" 
                                            value="1" 
                                            min="1" 
                                            class="w-20 px-3 py-2 border border-teal-light rounded-md text-center focus:border-teal-medium focus:ring-teal-light"
                                        >
                                    </div>
                                    <button type="submit" class="w-full bg-teal-gradient hover:opacity-90 text-white font-semibold py-3 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                                        Agregar al Carrito
                                    </button>
                                </form>
                                <a href="{{ route('cart.index') }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg text-center transition-colors">
                                    Ver Carrito
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
