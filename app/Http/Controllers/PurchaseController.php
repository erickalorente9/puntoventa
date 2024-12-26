<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\StoreRequest;
use App\Product;
use App\Provider;
use App\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['provider', 'user'])
            ->orderBy('purchase_date', 'desc')
            ->get();
        
        return view('admin.purchase.index', compact('purchases'));
    }

    public function create()
    {
        $providers = Provider::all();
        $products = Product::all();
        return view('admin.purchase.create', compact('providers', 'products'));
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
    
            // Crear la compra
            $purchase = Purchase::create([
                'provider_id' => $request->provider_id,
                'user_id' => auth()->id(),
                'purchase_date' => $request->purchase_date,
                'tax' => $request->tax,
                'total' => $request->total,
                'status' => 'VALID',
            ]);
    
            // Guardar los detalles de productos
            foreach ($products as $product) {
                $purchase->purchaseDetails()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ]);
    
                // Opcional: Actualizar el stock del producto si es necesario
                /*
                $productModel = Product::find($product['product_id']);
                $productModel->increment('stock', $product['quantity']);
                */
            }
    
            \DB::commit();
            
            return redirect()
                ->route('purchases.index')
                ->with('success', 'Compra creada con éxito!');
    
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error al crear la compra: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Error al procesar la compra. Por favor, intente nuevamente.')
                ->withInput();
        }
    }
    

    public function edit(Purchase $purchase)
    {
        $providers = Provider::all();
        $products = Product::all();
        $purchase->load('purchaseDetails.product');
        return view('admin.purchase.edit', compact('purchase', 'providers', 'products'));
    }

    public function update(StoreRequest $request, Purchase $purchase)
    {
        try {
            \DB::beginTransaction();
    
            $purchase->update([
                'provider_id' => $request->provider_id,
                'purchase_date' => $request->purchase_date,
                'tax' => $request->tax,
                'total' => $request->total,
            ]);
    
            // Eliminar los detalles antiguos
            $purchase->purchaseDetails()->delete();
    
            // Agregar los nuevos detalles
            $products = json_decode($request->products, true);
            foreach ($products as $product) {
                $purchase->purchaseDetails()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ]);
            }
    
            \DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Compra actualizada exitosamente');
    
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Error al actualizar la compra')->withInput();
        }
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Compra eliminada con éxito!');
    }
}
