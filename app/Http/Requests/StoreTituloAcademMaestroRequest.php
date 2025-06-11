<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTituloAcademMaestroRequest extends FormRequest
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
            'id_maestro' => 'required|exists:maestros,id',
            'grado_academico' => 'required|in:bachillerato,licenciatura,ingenieria,maestría,doctorado,diplomado',
            'nombre_titulo' => 'required|string|max:64',
            'nombre_universidad' => 'required|string|max:64',
            'calificacion' => 'required|numeric|between:0,100',
            'pais' => 'required|string|max:32',
            'inicio' => 'required|date',
            'conclusion' => 'required|date|after_or_equal:inicio',
        ];
    }
}
