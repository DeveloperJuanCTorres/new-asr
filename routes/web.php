<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::prefix('tienda')->group(function () {

//     // Listado general
//     Route::get('/', [ShopController::class, 'index'])
//         ->name('shop.index');

//     // Buscar
//     Route::get('/buscar', [ShopController::class, 'search'])
//         ->name('shop.search');

//     // Categoría
//     Route::get('/categoria/{slug}', [ShopController::class, 'category'])
//         ->name('shop.category');

//     // Producto detalle
//     Route::get('/producto/{slug}', [ShopController::class, 'show'])
//         ->name('shop.show');
// });

Route::get('/tienda', [ShopController::class, 'index'])
    ->name('shop.index');

Route::get('/tienda/categoria/{slug}', [ShopController::class, 'category'])
    ->name('shop.category');

Route::get('/producto/{slug}', [ShopController::class, 'show'])
    ->name('shop.show');

    Route::get('/buscar', [ShopController::class, 'search'])
    ->name('shop.search');

Route::prefix('carrito')->group(function () {

    Route::get('/', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add', [CartController::class, 'add'])
        ->name('cart.add');

    Route::post('/actualizar', [CartController::class, 'update'])
        ->name('cart.update');

    // Route::delete('/eliminar/{id}', [CartController::class, 'remove'])
    //     ->name('cart.remove');
});


Route::get('/cart/mini', [CartController::class, 'mini'])
    ->name('cart.mini');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::delete('/cart/clear', [CartController::class, 'clear'])
    ->name('cart.clear');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('orders.store');

Route::get('/about', [HomeController::class, 'about'])
    ->name('about');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('contact');

Route::get('/libro-reclamaciones', [App\Http\Controllers\HomeController::class, 'reclamaciones'])->name('libro.reclamaciones');


Route::prefix('checkout')->group(function () {

    Route::get('/', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/procesar', [CheckoutController::class, 'process'])
        ->name('checkout.process');

    Route::get('/gracias', [CheckoutController::class, 'thankyou'])
        ->name('checkout.thankyou');
});



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
