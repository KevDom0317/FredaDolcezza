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
        .bg-blur {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.85);
        }
        .product-card {
            width: 30%;
            background: linear-gradient(135deg, #fefefe 0%, #f8f8f8 100%);
            border: 2px solid;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
        }
        @media (max-width: 1024px) {
            .product-card {
                width: 48%;
            }
        }
        @media (max-width: 768px) {
            .product-card {
                width: 100%;
            }
        }
        .product-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 35px rgba(52, 91, 99, 0.2);
        }
        .product-image-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 0.5rem;
            position: relative;
            background: linear-gradient(135deg, var(--teal-pastel) 0%, var(--teal-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .product-card:hover .product-image {
            transform: scale(1.1) rotate(1deg);
        }
        .product-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(52, 91, 99, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .product-card:hover .product-image-overlay {
            opacity: 1;
        }
        .border-teal-dark { border-color: var(--teal-dark); }
        .border-teal-medium { border-color: var(--teal-medium); }
        .border-teal-light { border-color: var(--teal-light); }
        .bg-teal-gradient {
            background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal-medium) 50%, var(--teal-light) 100%);
        }
        .text-teal-dark { color: var(--teal-dark); }
        .text-teal-medium { color: var(--teal-medium); }
        .bg-teal-dark { background-color: var(--teal-dark); }
        .bg-teal-medium { background-color: var(--teal-medium); }
        .bg-teal-light { background-color: var(--teal-light); }
        .hover\:bg-teal-dark:hover { background-color: var(--teal-dark); }
        .hover\:bg-teal-medium:hover { background-color: var(--teal-medium); }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Fondo con imagen borrosa -->
    <div class="fixed inset-0 z-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#b8d4dc] via-[#7fb3c3] to-[#4a7c8a] opacity-50"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iYSIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIyIiBmaWxsPSIjMzQ1YjYzIiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNhKSIvPjwvc3ZnPg==')] opacity-20"></div>
    </div>

    <div class="relative z-10 min-h-screen">
        <!-- Header Superior: Logo y Redes Sociales -->
        <header class="relative bg-white/90 backdrop-blur-sm shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-teal-gradient rounded-full flex items-center justify-center shadow-md">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h1 class="font-dancing text-3xl font-bold text-teal-dark">
                            {{ config('app.name', 'Freda Dolcezza') }}
                        </h1>
                    </div>

                    <!-- Redes Sociales y Carrito -->
                    <div class="flex items-center space-x-4">
                        <!-- Redes Sociales -->
                        <div class="hidden md:flex items-center space-x-3">
                            <a href="#" class="w-8 h-8 bg-[#1877f2] rounded-full flex items-center justify-center hover:bg-[#166fe5] transition-colors shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-8 h-8 bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 rounded-full flex items-center justify-center hover:opacity-90 transition-opacity shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        </div>

                        <!-- Carrito -->
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-teal-dark transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="absolute -top-2 -right-2 bg-teal-dark text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-md">
                                        {{ count(session('cart')) }}
                                    </span>
                                @endif
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-teal-dark transition-colors text-sm font-medium">
                                    Panel
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Barra de Navegación -->
        <nav class="relative bg-teal-gradient shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center space-x-1 md:space-x-6 py-3">
                    <a href="{{ route('menu.index') }}" class="px-4 py-2 text-white hover:bg-white/20 rounded-md transition-colors font-medium text-sm md:text-base">
                        Inicio
                    </a>
                    <a href="#acerca" class="px-4 py-2 text-white hover:bg-white/20 rounded-md transition-colors font-medium text-sm md:text-base">
                        Acerca de nosotros
                    </a>
                    <a href="{{ route('menu.index') }}" class="px-4 py-2 text-white bg-white/30 rounded-md transition-colors font-medium text-sm md:text-base flex items-center">
                        Productos
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <a href="#galeria" class="px-4 py-2 text-white hover:bg-white/20 rounded-md transition-colors font-medium text-sm md:text-base flex items-center">
                        Galería
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <a href="#sucursales" class="px-4 py-2 text-white hover:bg-white/20 rounded-md transition-colors font-medium text-sm md:text-base">
                        Sucursales
                    </a>
                    <a href="#contacto" class="px-4 py-2 text-white hover:bg-white/20 rounded-md transition-colors font-medium text-sm md:text-base">
                        Contacto
                    </a>
                </div>
            </div>
        </nav>

        <!-- Contenido Principal -->
        <main class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if($categories->count() > 0)
                @foreach($categories as $index => $category)
                    <div class="mb-16">
                        <!-- Título de Categoría -->
                        <div class="text-center mb-8">
                            <h2 class="font-dancing text-5xl md:text-6xl font-bold text-teal-dark mb-2">
                                {{ $category->name }}
                            </h2>
                            @if($category->description)
                                <p class="text-gray-600 text-lg max-w-2xl mx-auto">{{ $category->description }}</p>
                            @endif
                        </div>

                        @if($category->products->count() > 0)
                            <div class="flex flex-wrap gap-4 justify-start">
                                @foreach($category->products as $productIndex => $product)
                                    @php
                                        $borderColors = ['border-teal-dark', 'border-teal-medium', 'border-teal-light'];
                                        $borderColor = $borderColors[$productIndex % count($borderColors)];
                                    @endphp
                                    <div class="product-card {{ $borderColor }} rounded-lg p-4 bg-white/90 backdrop-blur-sm">
                                        <!-- Imagen del producto con tamaño estándar y animación -->
                                        <div class="product-image-container mb-4">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-image">
                                                <div class="product-image-overlay"></div>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-20 h-20 text-teal-medium opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <h3 class="text-base font-bold text-gray-800 mb-1 leading-tight line-clamp-2">
                                                {{ $product->name }}
                                            </h3>
                                            @if($product->description)
                                                <p class="text-gray-600 text-xs mb-3 leading-relaxed line-clamp-2">
                                                    {{ Str::limit($product->description, 80) }}
                                                </p>
                                            @endif
                                            
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="text-lg font-bold text-teal-dark">
                                                    ${{ number_format($product->price, 2) }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex flex-col space-y-2">
                                                <a href="{{ route('menu.show', $product->id) }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1.5 rounded-md text-xs font-medium transition-colors text-center">
                                                    Ver
                                                </a>
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                                                    @csrf
                                                    <button type="submit" class="w-full bg-teal-gradient hover:opacity-90 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-all shadow-md hover:shadow-lg">
                                                        Agregar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-8">No hay productos disponibles en esta categoría.</p>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-20 bg-white/90 backdrop-blur-sm rounded-lg">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No hay categorías disponibles en el menú.</p>
                </div>
            @endif
        </main>

        <!-- Footer -->
        <footer class="relative bg-teal-dark text-white mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <p class="font-dancing text-2xl mb-2">{{ config('app.name', 'Freda Dolcezza') }}</p>
                    <p class="text-teal-pastel text-sm">© {{ date('Y') }} Todos los derechos reservados</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
