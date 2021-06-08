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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::resource('autors', \App\Http\Controllers\AutorController::class);
Route::resource('artworks', \App\Http\Controllers\ArtworkController::class);
Route::resource('cartItems', \App\Http\Controllers\CardItemController::class);
Route::resource('addresses', \App\Http\Controllers\AddressController::class);
Route::get('checkout', [\App\Http\Controllers\CardItemController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::prefix('payu')->group(function() {
    Route::get('confirmation', [\App\Http\Controllers\CardItemController::class, 'payuConfirmation'])->middleware('auth')->name('confirmation');
    Route::post('response', [\App\Http\Controllers\CardItemController::class, 'payuResponse'])->name('response');
});
Auth::routes();
