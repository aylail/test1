<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SalesController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/sales', [SalesController::class, 'index']);
Route::delete('sales', [SalesController::class, 'delete']);

Route::post('/products/purchase', [ProductController::class, 'purchase']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
