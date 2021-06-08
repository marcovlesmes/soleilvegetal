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
Route::resource('autors', \App\Http\Controllers\AutorController::class)->only(['index', 'show']);
Route::resource('artworks', \App\Http\Controllers\ArtworkController::class)->only(['index', 'show']);
Route::resource('cartItems', \App\Http\Controllers\CardItemController::class)->only(['store', 'destroy']);
Route::resource('addresses', \App\Http\Controllers\AddressController::class)->only(['store', 'update', 'destroy']);
Route::get('checkout', [\App\Http\Controllers\CardItemController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::prefix('payu')->group(function() {
    Route::get('confirmation', [\App\Http\Controllers\CardItemController::class, 'payuConfirmation'])->middleware('auth')->name('confirmation');
    Route::post('response', [\App\Http\Controllers\CardItemController::class, 'payuResponse'])->name('response');
});
Route::prefix('dashboard')->middleware('auth')->group(function() {
    Route::get('/', [\App\Http\Controllers\CarouselController::class, 'index'])->name('dashboard');
    Route::resource('carousel', \App\Http\Controllers\CarouselController::class)->except(['index']);
    Route::get('artworks', [\App\Http\Controllers\ArtworkController::class, 'list'])->name('artworks.list');
    Route::resource('artworks', \App\Http\Controllers\ArtworkController::class)->except(['index', 'show']);
    Route::resource('orders', \App\Http\Controllers\OrderController::class);
});
Auth::routes();
