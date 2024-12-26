<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
    {
        //
        $clients = Client::get();
        return view('admin.client.index',compact('clients'));
    }

   
    public function create()
    {
        //
        return view('admin.client.create');

    }

  
    public function store(StoreRequest $request)
    {
        //
        Client::create($request->all());
        return redirect()->route('clients.index');
  

    }


    public function show(Client $client)
    {
        //
        return view('admin.client.show',compact('client'));


    }


    public function edit(Client $client)
    {
        //
        return view('admin.client.edit',compact('client'));
    }

 
    public function update(UpdateRequest $request, Client $client)
    {
        \Log::info('Datos recibidos:', $request->all());

        $client->update($request->all());


        return redirect()->route('clients.index')->with('success', 'Cliente actualizado con éxito');
    }
    

   
    public function destroy(Client $client)
    {
        //
        $client->delete();
        return redirect()->route('clients.index');

    }
}