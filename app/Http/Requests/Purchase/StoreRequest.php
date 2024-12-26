<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Puedes cambiarlo si deseas control de acceso
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider_id' => 'required|exists:providers,id',
            'purchase_date' => 'required|date',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'products' => 'required|json',
        ];
    }
    /**
     * Get custom attributes for validation errors.
     *
     * @return array
     */
}