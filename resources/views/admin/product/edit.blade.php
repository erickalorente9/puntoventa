@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <h2 class="mb-4">Editar Producto</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label for="sell_price">Precio de Venta</label>
            <input type="number" step="0.01" class="form-control" id="sell_price" name="sell_price" value="{{ old('sell_price', $product->sell_price) }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select class="form-control" id="category_id" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="provider_id">Proveedor</label>
            <select class="form-control" id="provider_id" name="provider_id" required>
                @foreach($providers as $provider)
                    <option value="{{ $provider->id }}" {{ $provider->id == $product->provider_id ? 'selected' : '' }}>{{ $provider->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <div class="form-group">
            <label for="image">Imagen</label>
            <input type="file" class="form-control-file" id="image" name="image">
            @if($product->image)
                <div class="mt-2">
                    <p>Imagen actual:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen de {{ $product->name }}" style="height: 100px; object-fit: cover;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Actualizar Producto</button>
    </form>
</div>
@endsection