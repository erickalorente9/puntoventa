@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <h2>Registrar Venta</h2>

    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
        @csrf
        
        <!-- Mantener los mismos campos del cliente, usuario y fecha -->
        <div class="form-group">
            <label for="client">Cliente:</label>
            <select class="form-control" id="client" name="client_id" required>
                <option value="">Selecciona un Cliente</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tax">Impuesto (%):</label>
            <input type="number" step="0.01" class="form-control" id="tax" name="tax" required>
        </div>
        <div class="form-group">
            <label for="sale_date">Fecha de Venta:</label>
            <input type="date" class="form-control" id="sale_date" name="sale_date" required>
        </div>

        <!-- Sección de productos -->
        <div class="card mb-3">
            <div class="card-header">
                Agregar Productos
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <select class="form-control" id="product">
                            <option value="">Selecciona un Producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-price="{{ $product->price }}"
                                        data-name="{{ $product->name }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="quantity" placeholder="Cantidad" min="1">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="price" placeholder="Precio" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="discount" placeholder="Descuento (%)" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="add-product" class="btn btn-success">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table" id="product-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Subtotal:</label>
                    <input type="number" class="form-control" id="subtotal" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Impuestos:</label>
                    <input type="number" class="form-control" id="total_tax" readonly>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Total:</label>
                    <input type="number" class="form-control" id="total" name="total" readonly>
                </div>
            </div>
        </div>

        <!-- Campo oculto para los productos -->
        <input type="hidden" name="products" id="products-input">

        <button type="submit" class="btn btn-primary">Guardar Venta</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let products = [];
    const form = document.getElementById('saleForm');
    const addButton = document.getElementById('add-product');
    const productTable = document.getElementById('product-table').getElementsByTagName('tbody')[0];
    const taxInput = document.getElementById('tax');

    // Función para actualizar la tabla
    function updateTable() {
        productTable.innerHTML = '';
        products.forEach((item, index) => {
            const row = productTable.insertRow();
            row.innerHTML = `
                <td>${item.productName}</td>
                <td>${item.quantity}</td>
                <td>${item.price}</td>
                <td>${item.discount}%</td>
                <td>${(item.quantity * item.price * (1 - item.discount / 100)).toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${index})">
                        Eliminar
                    </button>
                </td>
            `;
        });
        calculateTotals();
    }

    // Función para calcular totales
    function calculateTotals() {
        const subtotalNoDiscount = products.reduce((sum, item) => sum + (item.quantity * item.price), 0);
        const taxRate = parseFloat(taxInput.value) || 0;
        
        // Calcular el subtotal con los descuentos aplicados
        const subtotalWithDiscount = products.reduce((sum, item) => {
            const discountAmount = item.quantity * item.price * (item.discount / 100);
            return sum + (item.quantity * item.price - discountAmount);
        }, 0);
        
        // Calcular el impuesto sobre el subtotal con descuento
        const taxAmount = subtotalWithDiscount * (taxRate / 100);
        
        // Calcular el total final
        const total = subtotalWithDiscount + taxAmount;

        // Mostrar los resultados en los campos correspondientes
        document.getElementById('subtotal').value = subtotalWithDiscount.toFixed(2);
        document.getElementById('total_tax').value = taxAmount.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }

    // Agregar producto
    addButton.addEventListener('click', function() {
        const productSelect = document.getElementById('product');
        const quantity = document.getElementById('quantity');
        const price = document.getElementById('price');
        const discount = document.getElementById('discount');

        if (!productSelect.value || !quantity.value || !price.value || !discount.value) {
            alert('Por favor complete todos los campos del producto');
            return;
        }

        const product = {
            product_id: parseInt(productSelect.value),
            productName: productSelect.options[productSelect.selectedIndex].text,
            quantity: parseInt(quantity.value),
            price: parseFloat(price.value),
            discount: parseFloat(discount.value)
        };

        products.push(product);
        updateTable();

        // Limpiar campos
        productSelect.value = '';
        quantity.value = '';
        price.value = '';
        discount.value = '';
    });

    // Eliminar producto
    window.removeProduct = function(index) {
        products.splice(index, 1);
        updateTable();
    }

    // Actualizar totales cuando cambia el impuesto
    taxInput.addEventListener('input', calculateTotals);

    // Manejar el envío del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (products.length === 0) {
            alert('Debe agregar al menos un producto');
            return;
        }

        // Convertir el array de productos a JSON y asignarlo al campo oculto
        document.getElementById('products-input').value = JSON.stringify(products);
        
        // Enviar el formulario
        this.submit();
    });
});
</script>
@endsection
