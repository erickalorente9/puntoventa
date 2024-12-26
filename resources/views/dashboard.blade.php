
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Punto de Venta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content {
            padding: 20px;
        }
        .card-stat {
            transition: transform 0.2s ease;
        }
        .card-stat:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h2>Bienvenido, Admin</h2>
                    <p>Resumen de tus estadísticas</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-primary card-stat">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Total Ventas</h5>
                                    <h2>${{ number_format($totalSales, 2) }}</h2> <!-- Muestra el total de ventas -->
                                </div>
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success card-stat">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Productos</h5>
                                    <h2>{{ $productCount }}</h2> <!-- Contar el número de productos -->
                                </div>
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning card-stat">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Clientes</h5>
                                    <h2>{{ $clientCount }}</h2> <!-- Contar el número de clientes -->
                                </div>
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ventas Recientes -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Ventas Recientes
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentSales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->client->name }}</td>
                                        <td>${{ number_format($sale->total, 2) }}</td>
                                        <td>
                                            @if($sale->status == 'completed')
                                                <span class="badge bg-success">Completado</span>
                                            @elseif($sale->status == 'pending')
                                                <span class="badge bg-warning">Pendiente</span>
                                            @else
                                                <span class="badge bg-danger">Cancelado</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Puedes agregar más contenido si lo necesitas -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Actividad Reciente
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">Juan Pérez realizó una compra de $150</li>
                                <li class="list-group-item">Se agregó un nuevo producto: "Laptop HP"</li>
                                <li class="list-group-item">María López solicitó una devolución</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection