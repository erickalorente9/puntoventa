@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container">
        <h1>Crear Producto</h1>

        <!-- Mostrar errores de validación -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de creación de producto -->
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="code">Código del Producto</label>
                <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="name">Nombre del Productos</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="image">Imagen del Producto</label>
                <input type="file" class="form-control" name="image" id="image" required>
            </div>

            <div class="form-group">
                <label for="stock">Cantidad en Stock</label>
                <input type="number" class="form-control" name="stock" id="stock" value="{{ old('stock') }}" required min="0">
            </div>

            <div class="form-group">
                <label for="sell_price">Precio de Venta</label>
                <input type="number" step="0.01" class="form-control" name="sell_price" id="sell_price" value="{{ old('sell_price') }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Categoría</label>
                <select class="form-control" name="category_id" id="category_id" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="provider_id">Proveedor</label>
                <select class="form-control" name="provider_id" id="provider_id" required>
                    <option value="">Seleccione un proveedor</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Producto</button>
        </form>
    </div>
@endsection