<?php

namespace App\Http\Requests\Client;

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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'dni' => 'required|unique:clients,dni|max:255',
            'ruc' => 'nullable|unique:clients,ruc|max:255',
            'address' => 'nullable|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'required|email|unique:clients,email|max:255',
        ];
    }

    public function messaages()
    {
        return [
            'name.required' => 'Este campo es requerido.',
            'name.string'   => 'El valor no es correcto.',
            'name.max'      => 'Solo se permiten 255 caracteres.',

            'dni.string'    => 'El valor no es correcto.',
            'dni.required'  => 'Este campo es requerido.',
            'dni.unique'    => 'Este DNI ya se encuentra registrado.',
            'dni.min'      => 'Se requieren 8 caracteres.',
            'dni.max'      => 'Solo se permiten 8 caracteres.',

            'ruc.string'    => 'El valor no es correcto.',
            'ruc.unique'    => 'El número de RUC ya se encuentra registrado.',
            'ruc.min'      => 'Se requieren 11 caracteres.',
            'ruc.max'      => 'Solo se permiten 11 caracteres.',

            'address.string' => 'El valor no es correcto.',
            'address.max'   => 'Solo se permiten 255 caracteres.',

            'phone.string' => 'El valor no es correcto.',
            'phone.unique' => 'El número de celular ya se encuentra registrado.',
            'phone.min' => 'Se requiere de 10 caracteres.',
            'phone.max' => 'Solo se permite 10 caracteres.',

            'email.string' => 'El valor no es correcto.',
            'email.unique' => 'La dirección de correo electrónico ya se encuentra registrada.',
            'email.max' => 'Solo se permite 255 caracteres.',
            'email.email' => 'No es un correo electrónico válido.'
        ];
    }
}