<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
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
        ];
    }
}
