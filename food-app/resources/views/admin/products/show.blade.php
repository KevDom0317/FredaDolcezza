@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Ver Producto')

@php
    $pageTitle = 'Ver Producto';
    $breadcrumbs = [
        ['label' => 'Productos', 'url' => route('admin.products.index')],
        ['label' => 'Ver']
    ];
@endphp

@section('header-actions')
<a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-medium">
    ← Volver a Productos
</a>
<a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-gradient hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-medium">
    Editar
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Imagen -->
            <div>
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-contain rounded-lg border border-gray-200 bg-gray-50 p-4">
                @else
                    <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Información -->
            <div class="space-y-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>
                    <p class="text-3xl font-bold text-teal-dark mb-4">${{ number_format($product->price, 2) }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Categoría</h3>
                    <p class="text-gray-900">{{ $product->category->name }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Estado</h3>
                    @if($product->is_available)
                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Disponible
                        </span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            No disponible
                        </span>
                    @endif
                </div>

                @if($product->description)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Descripción</h3>
                        <p class="text-gray-900">{{ $product->description }}</p>
                    </div>
                @endif

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Fecha de creación</h3>
                    <p class="text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-gradient hover:opacity-90">
                            Editar Producto
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

