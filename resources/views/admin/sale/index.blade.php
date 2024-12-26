@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h1>Lista de Ventas</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Crear Nueva Venta</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->client->name }}</td> <!-- Relación con Cliente -->
                    <td>{{ $sale->user->name }}</td> <!-- Relación con Usuario -->
                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                    <td>{{ number_format($sale->total, 2) }}</td>
                    <td>{{ $sale->status }}</td>
                    <td>
                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" style="display:inline;">
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
