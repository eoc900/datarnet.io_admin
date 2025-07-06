<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaestroRequest extends FormRequest
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
            'nombre' => 'required|string|max:32',
            'apellido_paterno' => 'required|string|max:32',
            'apellido_materno' => 'required|string|max:32',
            'estado_sistema' => 'required|in:Activo,Inactivo',
            'telefono' => 'required|string|max:15',
            'correo_institucional' => 'required|email|max:255',
            'correo_personal' => 'required|email|max:255',
            'calle' => 'required|string|max:120',
            'codigo_postal' => 'required|string|max:10',
            'ciudad' => 'required|string|max:32',
            'estado' => 'required|string|max:24',
            'inicio_contrato' => 'required',
        ];
    }
}
