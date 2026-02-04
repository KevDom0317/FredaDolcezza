@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menú - {{ config('app.name', 'Laravel') }}</title>
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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nuestro Menú</h1>
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
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if($categories->count() > 0)
                @foreach($categories as $category)
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                            {{ $category->name }}
                        </h2>
                        @if($category->description)
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $category->description }}</p>
                        @endif

                        @if($category->products->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($category->products as $product)
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <span class="text-gray-400">Sin imagen</span>
                                            </div>
                                        @endif
                                        <div class="p-4">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                                {{ $product->name }}
                                            </h3>
                                            @if($product->description)
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                                    {{ Str::limit($product->description, 100) }}
                                                </p>
                                            @endif
                                            <div class="flex justify-between items-center">
                                                <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                                    ${{ number_format($product->price, 2) }}
                                                </span>
                                                <a href="{{ route('menu.show', $product->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                                    Ver Detalle
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No hay productos disponibles en esta categoría.</p>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No hay categorías disponibles en el menú.</p>
                </div>
            @endif
        </main>
    </div>
</body>
</html>

