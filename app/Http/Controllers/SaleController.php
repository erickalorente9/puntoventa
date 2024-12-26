<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\StoreRequest;
use App\Sale;
use App\Product;
use App\Client;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        // Obtener las ventas con las relaciones de cliente, usuario y detalles
        $sales = Sale::with(['client', 'user', 'saleDetails.product'])
            ->orderBy('sale_date', 'desc')
            ->get();
        
        return view('admin.sale.index', compact('sales'));
    }

    public function create()
    {
        // Obtener los clientes y productos para el formulario de creación
        $clients = Client::all();
        $products = Product::all();
        return view('admin.sale.create', compact('clients', 'products'));
    }

    public function store(StoreRequest $request)
    {
        try {
            \Log::info('Datos recibidos:', $request->all());
    
            // Decodificar el JSON de productos
            $products = json_decode($request->products, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', 'Error en el formato de los productos')->withInput();
            }
    
            if (empty($products)) {
                return back()->with('error', 'Debe agregar al menos un producto')->withInput();
            }
    
            \DB::beginTransaction();
    
            // Crear la venta
            $sale = Sale::create([
                'client_id' => $request->client_id,
                'user_id' => auth()->id(),
                'sale_date' => $request->sale_date,
                'tax' => $request->tax,
                'total' => $request->total,
                'status' => 'VALID', // Cambia el estado si es necesario
            ]);
    
            // Guardar los detalles de productos
            foreach ($products as $product) {
                $sale->saleDetails()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'discount' => $product['discount'] ?? 0, // Si no hay descuento, se asigna 0
                ]);
    
                // Opcional: Actualizar el stock del producto si es necesario
                /*
                $productModel = Product::find($product['product_id']);
                $productModel->decrement('stock', $product['quantity']);
                */
            }
    
            \DB::commit();
    
            return redirect()
                ->route('sales.index')
                ->with('success', 'Venta creada con éxito!');
    
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error al crear la venta: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Error al procesar la venta. Por favor, intente nuevamente.')
                ->withInput();
        }
    }
    

    public function edit(Sale $sale)
    {
        // Obtener los clientes y productos para el formulario de edición
        $clients = Client::all();
        $products = Product::all();
        $sale->load('saleDetails.product'); // Cargar detalles de productos
        return view('admin.sale.edit', compact('sale', 'clients', 'products'));
    }

    public function update(StoreRequest $request, Sale $sale)
    {
        try {
            \DB::beginTransaction();
    
            // Actualizar la venta
            $sale->update([
                'client_id' => $request->client_id,
                'sale_date' => $request->sale_date,
                'tax' => $request->tax,
                'total' => $request->total,
                'status' => $request->status, // Permitir el cambio de estado
            ]);
    
            // Eliminar los detalles antiguos
            $sale->saleDetails()->delete();
    
            // Agregar los nuevos detalles
            $products = json_decode($request->products, true);
            foreach ($products as $product) {
                $sale->saleDetails()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'discount' => $product['discount'] ?? 0, // Si no hay descuento, se asigna 0
                ]);
            }
    
            \DB::commit();
            return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente');
    
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Error al actualizar la venta')->withInput();
        }
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venta eliminada con éxito!');
    }
}