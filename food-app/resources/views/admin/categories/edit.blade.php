@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Editar Categoría')

@php
    $pageTitle = 'Editar Categoría';
    $breadcrumbs = [
        ['label' => 'Categorías', 'url' => route('admin.categories.index')],
        ['label' => 'Editar']
    ];
@endphp

@section('header-actions')
<a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-medium">
    Cancelar
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Categoría</label>
                <input id="name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-medium focus:border-teal-medium" type="text" name="name" value="{{ old('name', $category->name) }}" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea id="description" name="description" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-medium focus:border-teal-medium">{{ old('description', $category->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <!-- Imagen Actual -->
            @if($category->image)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagen Actual</label>
                    <div class="mt-2">
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="h-32 w-32 object-cover rounded border border-gray-300">
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

            <!-- Estado Activo -->
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-teal-dark shadow-sm focus:ring-teal-medium">
                    <span class="ml-2 text-sm text-gray-700">Categoría activa</span>
                </label>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.categories.index') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-gradient hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-medium">
                    Actualizar Categoría
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
