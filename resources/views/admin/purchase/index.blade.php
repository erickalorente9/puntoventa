@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h1>Lista de Compras</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <a href="{{ route('purchases.create') }}" class="btn btn-primary mb-3">Crear Nueva Compra</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Proveedor</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->id }}</td>
                    <td>{{ $purchase->provider->name }}</td>
                    <td>{{ $purchase->user->name }}</td>
                    <td>{{ $purchase->purchase_date->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($purchase->total, 2) }}</td>
                    <td>{{ $purchase->status }}</td>
                    <td>
                        <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
