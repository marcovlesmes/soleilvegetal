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
Route::post('checkout', [\App\Http\Controllers\CardItemController::class, 'checkout'])->name('checkout');
Auth::routes();
