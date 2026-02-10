@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
<div class="bg-white rounded-lg shadow border border-gray-200">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-900">Bienvenido al Panel de Administración</h1>
        <p class="mb-6 text-gray-600">Desde aquí podrás gestionar productos, categorías y pedidos.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-teal-pastel border-2 border-teal-light p-6 rounded-lg hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-teal-medium rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-teal-dark">Productos</h3>
                </div>
                <p class="text-sm mb-3 text-gray-600">Gestiona tu menú de productos</p>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-teal-dark hover:text-teal-medium font-medium hover:underline inline-flex items-center">
                    Gestionar productos →
                </a>
            </div>
            <div class="bg-teal-pastel border-2 border-teal-light p-6 rounded-lg hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-teal-medium rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-teal-dark">Categorías</h3>
                </div>
                <p class="text-sm mb-3 text-gray-600">Organiza tus productos por categorías</p>
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-teal-dark hover:text-teal-medium font-medium hover:underline inline-flex items-center">
                    Gestionar categorías →
                </a>
            </div>
            <div class="bg-teal-pastel border-2 border-teal-light p-6 rounded-lg hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-teal-medium rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-teal-dark">Pedidos</h3>
                </div>
                <p class="text-sm mb-3 text-gray-600">Revisa y gestiona los pedidos</p>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-teal-dark hover:text-teal-medium font-medium hover:underline inline-flex items-center">
                    Gestionar pedidos →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
