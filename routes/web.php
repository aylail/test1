<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'getLists'])->name('products')->middleware('auth');
Route::get('/regists/create', [ProductController::class, 'create'])->name('regists.create')->middleware('auth');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store')->middleware('auth');
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth');
Route::get('/products/show/{id}', [ProductController::class, 'show'])->name('products.show')->middleware('auth');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('auth');
Route::get('/products/searchword', [ProductController::class, 'searchWord'])->name('products.searchword')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
