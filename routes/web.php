<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'products');

Route::any('payme/soqqadi-chiqar', PaymeController::class)->middleware('payme');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class)
            ->only(['index', 'show',]);

    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/{product}/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::put('cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/delete', [CartController::class, 'destroy'])->name('cart.delete');
});

require __DIR__.'/auth.php';
