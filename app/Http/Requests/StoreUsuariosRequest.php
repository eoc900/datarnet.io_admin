<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuariosRequest extends FormRequest
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
            'name' => 'required|string|max:32',
            'lastname' => 'required|string|max:32',
            'email' => 'required|email|max:255|unique:users',
            'telephone' => 'required|string|max:14',
            'user_type' => 'required|string|max:32',
            'estado' => 'required|string|max:24',
        ];
    }
}
