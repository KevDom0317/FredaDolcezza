@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nombre del Producto')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Categoría -->
                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Categoría')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Precio -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Precio')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" step="0.01" min="0" :value="old('price', $product->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ingrese el precio en formato decimal (ej: 15.50)</p>
                        </div>

                        <!-- Imagen Actual -->
                        @if($product->image)
                            <div class="mb-4">
                                <x-input-label :value="__('Imagen Actual')" />
                                <div class="mt-2">
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded">
                                </div>
                            </div>
                        @endif

                        <!-- Nueva Imagen -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Nueva Imagen (opcional)')" />
                            <input id="image" name="image" type="file" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Formatos permitidos: JPEG, PNG, JPG, GIF. Tamaño máximo: 2MB</p>
                        </div>

                        <!-- Estado Disponible -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_available" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900">
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Producto disponible') }}</span>
                            </label>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Producto') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



