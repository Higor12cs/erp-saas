<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric', 'gte:0'],
            'price' => ['required', 'numeric', 'gte:0'],
            'is_active' => ['nullable', 'boolean'],
            'created_by' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo é obrigatório.',
            'string' => 'O campo deve ser uma string.',
            'max' => 'O campo deve ter no máximo :max caracteres.',
            'boolean' => 'O campo deve ser um booleano.',
            'integer' => 'O campo deve ser um inteiro.',
            'numeric' => 'O campo deve ser um número.',
            'gte' => 'O campo deve ser maior ou igual a :value.',
            'exists' => 'O valor selecionado para o campo é inválido.',
        ];
    }
}
