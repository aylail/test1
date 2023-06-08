<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ProductController;
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

Route::get('/products','App\Http\Controllers\ProductController@getLists')->name('products.index');
// /products = viewindexに遷移

//Route::resource('products', ProductController::class);

Route::get('/regists/create', 'App\Http\Controllers\ProductController@create')->name('regists.create')->middleware('auth');

Route::get('/products/store/', 'App\Http\Controllers\ProductController@store')->name('products.store')->middleware('auth');
Route::post('/products/store/', 'App\Http\Controllers\ProductController@store')->name('products.store')->middleware('auth');

Route::delete('/products/destroy{id}', 'App\Http\Controllers\ProductController@destroy')->name('products.destroy')->middleware('auth');
Route::get('/products/show/{id}', 'App\Http\Controllers\ProductController@show')->name('products.show')->middleware('auth');
Route::get('/products/edit{id}', 'App\Http\Controllers\ProductController@edit')->name('products.edit')->middleware('auth');

Route::get('/products/update', 'App\Http\Controllers\ProductController@update')->name('products.update')->middleware('auth');
Route::post('/products/update', 'App\Http\Controllers\ProductController@update')->name('products.update')->middleware('auth');

Route::get('/products', 'App\Http\Controllers\ProductController@getLists')->name('products')->middleware('auth');

Route::get('/products/searchword', 'App\Http\Controllers\ProductController@searchWord')->name('products.searchword');//->middleware('auth');

/*Route::controller(ProductController::class)->prefix('products')->name('products')->group(function(){
    Route::get('/','products');
    //Route::get(')ルートの一覧を追記できるかも
});*/


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
