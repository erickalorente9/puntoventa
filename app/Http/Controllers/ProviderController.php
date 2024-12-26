<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;
use App\Http\Requests\Provider\StoreRequest;
use App\Http\Requests\Provider\UpdateRequest;
class ProviderController extends Controller
{

    public function index()
    {
        //
        $providers = Provider::get();
        return view('admin.provider.index',compact('providers'));
    }

   
    public function create()
    {
        //
        return view('admin.provider.create');

    }

  
    public function store(StoreRequest $request)
    {
        //
        Provider::create($request->all());
        return redirect()->route('providers.index');
  

    }


    public function show(Provider $provider)
    {
        //
        return view('admin.provider.show',compact('provider'));


    }


    public function edit(Provider $provider)
    {
        return view('admin.provider.edit', compact('provider'));
    }
    

 
    public function update(UpdateRequest $request, Provider $provider)
    {
        // Actualizamos el proveedor con los datos validados
        $provider->update($request->validated());  // Usamos validated() para obtener solo los datos validados
    
        // Redirigimos con un mensaje de éxito
        return redirect()->route('providers.index')->with('success', 'Proveedor actualizado con éxito');
    }
    

   
    public function destroy(Provider $provider)
    {
        //
        $provider->delete();
        return redirect()->route('providers.index');

    }

}