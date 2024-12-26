<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

// Prefijo 'admin' para todas las rutas de administración
Route::prefix('admin')->middleware('admin')->group(function () {

    // Rutas para los recursos con nombres personalizados
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('clients', ClientController::class)->names('clients');
    Route::resource('products', ProductController::class)->names('products');
    Route::resource('providers', ProviderController::class)->names('providers');
    Route::resource('purchases', PurchaseController::class)->names('purchases');
    Route::resource('sales', SaleController::class)->names('sales');
    Route::resource('users', UserController::class)->names('users');
    Route::resource('dashboard', DashboardController::class)->names('dashboard');



});
Auth::routes();






