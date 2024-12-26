<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Client;
use App\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener las últimas 3 ventas recientes con los datos del cliente
        $recentSales = Sale::with('client')  // Traer los datos del cliente asociado a la venta
                            ->latest()  // Ordenar por la fecha de la venta (de más reciente a más antigua)
                            ->take(3)   // Limitar a las últimas 3
                            ->get();

        // Obtener el número total de clientes
        $clientCount = Client::count();

        // Obtener el número total de productos
        $productCount = Product::count();

        // Obtener el total de ventas (suma de los totales de todas las ventas)
        $totalSales = Sale::sum('total');

        // Puedes obtener otros datos si lo necesitas, como el número de órdenes pendientes, etc.

        // Retornar la vista con los datos obtenidos
        return view('dashboard', compact('recentSales', 'clientCount', 'productCount', 'totalSales'));
    }
}
