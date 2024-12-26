@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <h2 class="mb-4">Editar Cliente</h2>

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Método PUT para actualizar -->

        <!-- Campo para Nombre -->
        <div class="form-group mb-3">
            <label for="name">Nombre:</label>
            <input 
                type="text" 
                class="form-control" 
                id="name" 
                name="name" 
                value="{{ old('name', $client->name) }}" 
                required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para Correo Electrónico -->
        <div class="form-group mb-3">
            <label for="email">Correo Electrónico:</label>
            <input 
                type="email" 
                class="form-control" 
                id="email" 
                name="email" 
                value="{{ old('email', $client->email) }}" 
                required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para Dirección -->
        <div class="form-group mb-3">
            <label for="address">Dirección:</label>
            <input 
                type="text" 
                class="form-control" 
                id="address" 
                name="address" 
                value="{{ old('address', $client->address) }}">
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para Teléfono -->
        <div class="form-group mb-3">
            <label for="phone">Teléfono:</label>
            <input 
                type="text" 
                class="form-control" 
                id="phone" 
                name="phone" 
                value="{{ old('phone', $client->phone) }}" 
                required>
            @error('phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

<!-- Campo para DNI (Solo lectura) -->
<div class="form-group mb-3">
    <label for="dni">DNI:</label>
    <input 
        type="text" 
        class="form-control" 
        id="dni" 
        name="dni" 
        value="{{ $client->dni }}" 
        readonly>
</div>

<!-- Campo para RUC (Solo lectura) -->
<div class="form-group mb-3">
    <label for="ruc">RUC:</label>
    <input 
        type="text" 
        class="form-control" 
        id="ruc" 
        name="ruc" 
        value="{{ $client->ruc }}" 
        readonly>
</div>


        <!-- Botón de actualización -->
        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
    </form>
</div>
@endsection
