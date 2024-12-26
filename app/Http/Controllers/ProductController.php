<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        return view('admin.product.index', compact('products'));
    }
    public function inicio()
    {
        $products = Product::where('status', 1)->take(3)->get();
        return view('client.inicio', compact('products'));
    }
    public function productos()
    {
        $products = Product::get();
        return view('client.productos', compact('products'));
    }
    

    public function create()
    {
        $categories = Category::get();
        $providers = Provider::get();
        return view('admin.product.create', compact('categories', 'providers'));
    }

    public function store(StoreRequest $request)
    {
        // Valida si hay una imagen en la solicitud
        if ($request->hasFile('image')) {
            // Guarda la imagen en el directorio público de almacenamiento
            $imagePath = $request->file('image')->store('products', 'public');  // Guarda en storage/app/public/products
            // Incluye la ruta de la imagen en los datos del producto
            $productData = $request->all();
            $productData['image'] = $imagePath;  // Agrega la ruta de la imagen

            Product::create($productData);  // Crea el producto con los datos
        } else {
            // Si no se proporciona imagen, solo guarda los demás campos
            Product::create($request->all());
        }

        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::get();
        $providers = Provider::get();
        return view('admin.product.edit', compact('product', 'categories', 'providers'));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        // Si se selecciona una nueva imagen
        if ($request->hasFile('image')) {
            // Elimina la imagen anterior si existe
            if ($product->image) {
                unlink(storage_path('app/public/' . $product->image));
            }

            // Guarda la nueva imagen
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;  // Asigna la nueva imagen al producto
        }

        // Actualiza los otros campos del producto
        $product->update($request->except('image'));  // Excluye la imagen, porque ya la hemos manejado

        return redirect()->route('products.index');
    }



    public function destroy(Product $product)
    {
        // Elimina la imagen si existe antes de eliminar el producto
        if ($product->image) {
            unlink(storage_path('app/public/' . $product->image));
        }

        $product->delete();
        return redirect()->route('products.index');
    }

    
}