<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Crear Nueva Categoría') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-teal-light">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nombre de la Categoría')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-teal-light focus:border-teal-medium focus:ring-teal-light rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Imagen -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Imagen')" />
                            <input id="image" name="image" type="file" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-pastel file:text-teal-dark hover:file:bg-teal-light">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Formatos permitidos: JPEG, PNG, JPG, GIF. Tamaño máximo: 2MB</p>
                        </div>

                        <!-- Estado Activo -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-teal-light text-teal-dark shadow-sm focus:ring-teal-light">
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Categoría activa') }}</span>
                            </label>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.categories.index') }}" class="text-teal-dark hover:text-teal-medium font-medium">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Crear Categoría') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



