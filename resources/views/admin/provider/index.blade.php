@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <h2>Listado de Proveedores</h2>

    <a href="{{ route('providers.create') }}" class="btn btn-primary mb-3">Registrar Nuevo Proveedor</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Número de RUC</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($providers as $provider)
            <tr>
                <td>{{ $provider->name }}</td>
                <td>{{ $provider->email }}</td>
                <td>{{ $provider->ruc_number }}</td>
                <td>{{ $provider->address }}</td>
                <td>{{ $provider->phone }}</td>
                <td>
                <a href="{{ route('providers.edit', $provider->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('providers.destroy', $provider->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection