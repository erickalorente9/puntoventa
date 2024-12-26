@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <h2 class="mb-4">Crear Nueva Categoría</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <!-- Campo para Nombre -->
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input 
                type="text" 
                class="form-control" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para Descripción -->
        <div class="form-group">
            <label for="description">Descripción:</label>
            <textarea 
                class="form-control" 
                id="description" 
                name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón para crear -->
        <button type="submit" class="btn btn-primary">Crear Categoría</button>
    </form>
</div>
@endsection