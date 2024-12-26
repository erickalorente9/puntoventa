<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize()
    {
        return true; // Cambiar según tus necesidades de autorización.
    }

    /**
     * Reglas de validación para la solicitud.
     */
    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'sale_date' => 'required|date',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'products' => 'required|json',

        ];
    }
    /**
     * Mensajes de error personalizados (opcional).
     */

}