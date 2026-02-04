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
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <a href="{{ route('menu.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                        ← Volver al Menú
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
        </header>

        <!-- Contenido -->
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex">
                    <!-- Imagen -->
                    <div class="md:w-1/2">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-64 md:h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-400">Sin imagen</span>
                            </div>
                        @endif
                    </div>

                    <!-- Información -->
                    <div class="md:w-1/2 p-8">
                        <div class="mb-4">
                            <span class="inline-block bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 text-sm font-semibold px-3 py-1 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $product->name }}
                        </h1>

                        <div class="mb-6">
                            <span class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        </div>

                        @if($product->description)
                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Descripción</h2>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ $product->description }}
                                </p>
                            </div>
                        @endif

                        <div class="flex items-center space-x-4">
                            @if($product->is_available)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    No disponible
                                </span>
                            @endif
                        </div>

                        <!-- Botón para agregar al carrito -->
                        @if($product->is_available)
                            <div class="mt-6">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                                    @csrf
                                    <div class="flex items-center space-x-4 mb-4">
                                        <label for="quantity" class="text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad:</label>
                                        <input 
                                            type="number" 
                                            id="quantity"
                                            name="quantity" 
                                            value="1" 
                                            min="1" 
                                            class="w-20 px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-center"
                                        >
                                    </div>
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                                        Agregar al Carrito
                                    </button>
                                </form>
                                <a href="{{ route('cart.index') }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition-colors">
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

