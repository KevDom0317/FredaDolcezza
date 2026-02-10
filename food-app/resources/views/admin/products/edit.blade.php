@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Editar Producto')

@php
    $pageTitle = 'Editar Producto';
    $breadcrumbs = [
        ['label' => 'Productos', 'url' => route('admin.products.index')],
        ['label' => 'Editar']
    ];
@endphp

@section('header-actions')
<a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-medium">
    Cancelar
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="p-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Producto</label>
                <input id="name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-medium focus:border-teal-medium" type="text" name="name" value="{{ old('name', $product->name) }}" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea id="description" name="description" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-medium focus:border-teal-medium">{{ old('description', $product->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <!-- Categoría -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select id="category_id" name="category_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-medium focus:border-teal-medium" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
            </div>

            <!-- Precio -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                <input id="price" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-medium focus:border-teal-medium" type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required />
                <x-input-error :messages="$errors->get('price')" class="mt-1" />
                <p class="mt-1 text-sm text-gray-500">Ingrese el precio en formato decimal (ej: 15.50)</p>
            </div>

            <!-- Imagen Actual -->
            @if($product->image)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagen Actual</label>
                    <div class="mt-2">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded border border-gray-300">
                    </div>
                </div>
            @endif

            <!-- Nueva Imagen -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Nueva Imagen (opcional)</label>
                <input id="image" name="image" type="file" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-pastel file:text-teal-dark hover:file:bg-teal-light">
                <x-input-error :messages="$errors->get('image')" class="mt-1" />
                <p class="mt-1 text-sm text-gray-500">Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP. Tamaño máximo: 2MB</p>
            </div>

            <!-- Estado Disponible -->
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }} class="rounded border-gray-300 text-teal-dark shadow-sm focus:ring-teal-medium">
                    <span class="ml-2 text-sm text-gray-700">Producto disponible</span>
                </label>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-gradient hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-medium">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
