<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.string' => 'El nombre debe ser texto válido.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.unique' => 'Ya existe una categoría con ese nombre.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif o webp.',
            'image.max' => 'La imagen no puede pesar más de 2MB.',
        ];
    }
}
