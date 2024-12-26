<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'string|required|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|min:10|max:10|unique:clients,phone,' . $this->route('client')->id,
            'email' => 'nullable|string|max:255|email:rfc,dns|unique:clients,email,' . $this->route('client')->id
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Este campo es requerido.',
            'name.string'   => 'El valor no es correcto.',
            'name.max'      => 'Solo se permiten 255 caracteres.',

            'dni.string'    => 'El valor no es correcto.',
            'dni.required'  => 'Este campo es requerido.',
            'dni.unique'    => 'Este DNI ya se encuentra registrado.',
            'dni.min'      => 'Se requieren 10 caracteres.',
            'dni.max'      => 'Solo se permiten 10 caracteres.',

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