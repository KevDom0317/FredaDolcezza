<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer_name' => ['required', 'string', 'max:255', 'min:3'],
            'customer_phone' => ['required', 'string', 'max:20', 'regex:/^[\d\s\-\+\(\)]+$/'],
            'notes' => ['nullable', 'string', 'max:1000'],
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
            'customer_name.required' => 'El nombre es obligatorio.',
            'customer_name.string' => 'El nombre debe ser texto válido.',
            'customer_name.max' => 'El nombre no puede exceder 255 caracteres.',
            'customer_name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'customer_phone.required' => 'El teléfono es obligatorio.',
            'customer_phone.string' => 'El teléfono debe ser texto válido.',
            'customer_phone.max' => 'El teléfono no puede exceder 20 caracteres.',
            'customer_phone.regex' => 'El formato del teléfono no es válido.',
            'notes.max' => 'Las notas no pueden exceder 1000 caracteres.',
        ];
    }
}




