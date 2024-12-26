<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'string|required|unique:products,name|max:255',  
            'image' => 'required|dimensions:min_width=100,min_height=200',
            'sell_price' => 'required',
            'category_id' => 'integer|required|exists:App\Category,id',
            'provider_id' => 'integer|required|exists:App\Provider,id',
        ];
    }

    public function messages() {
        return [
            'name.string' => 'El valor no es correcto.',
            'name.required' => 'El campo es requerido.',
            'name.unique' => 'El producto ya está registrado.',
            'name.max' => 'Solo se permiten 255 caracteres.',
        
            'image.required' => 'El campo es requerido.',
            'image.dimensions' => 'Solo se permiten imágenes de 100x200 px.',
        
            'sell_price.required' => 'El campo es requerido.',
        
            'category_id.integer' => 'El valor tiene que ser entero.',
            'category_id.required' => 'El campo es requerido.',
            'category_id.exists' => 'La categoría no existe.',
        
            'provider_id.integer' => 'El valor tiene que ser entero.',
            'provider_id.required' => 'El campo es requerido.',
            'provider_id.exists' => 'El proveedor no existe.',
        ];
    }
}