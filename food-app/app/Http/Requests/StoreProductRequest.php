<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'],
            'is_available' => ['nullable', 'boolean'],
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
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.string' => 'El nombre debe ser texto válido.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número válido.',
            'price.min' => 'El precio debe ser mayor a 0.',
            'price.max' => 'El precio no puede exceder $999,999.99.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif o webp.',
            'image.max' => 'La imagen no puede pesar más de 2MB.',
            'category_id.required' => 'Debe seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }
}
