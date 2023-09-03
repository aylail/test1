<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sales::create([
        'id' => $request->id,
        /*'product_id' => $request->product_id*/]);
       // $product = Product::firstOrFail($productId);
       /*$request->validate([
        'product_id' => 'required',
        'id' => 'required',
       ]);*/
      
        return response()->json($sales);
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->delete();
        return response()->json();
    }

}
