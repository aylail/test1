<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use App\Models\Purchase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLists(Request $request)
    {
        $query = Product::query()->with('company');
    
        $searchword = $request->input('searchword');
        $companyName = $request->input('company_name');
    
        if (!empty($searchword)) {
            $query->where('id', 'LIKE', "%{$searchword}%")
                  ->orWhere('product_name', 'LIKE', "%{$searchword}%")
                  ->orWhere('price', 'LIKE', "%{$searchword}%")
                  ->orWhere('stock', 'LIKE', "%{$searchword}%")
                  ->orWhere('comment', 'LIKE', "%{$searchword}%");
        }
    
        if (!empty($companyName)) {
            $query->whereHas('company', function ($query) use ($companyName) {
                $query->where('company_name', $companyName);
            });
        }
    
        $products = $query->orderBy('id','desc')->get();
        $companies = Company::all();

        return view('products', compact('products', 'companies', 'searchword', 'companyName'));

    }
    //非同期検索機能
    public function search(Request $request)
    {
    $query = Product::query()->with('company');

    $searchword = $request->input('searchword');
    $companyName = $request->input('company_name');

    if (!empty($searchword)) {
        $query->where('product_name', 'LIKE', "%{$searchword}%")
            ->orWhere('price', 'LIKE', "%{$searchword}%")
            ->orWhere('stock', 'LIKE', "%{$searchword}%")
            ->orWhere('comment', 'LIKE', "%{$searchword}%");
    }

    if (!empty($companyName)) {
        $query->whereHas('company', function ($query) use ($companyName) {
            $query->where('company_name', $companyName);
        });
    }

    $products = $query->orderBy('price', 'desc')->get();


    return response()->json($products);
}

    
public function searchProducts(Request $request)
{
    $column = $request->input('column');
    $order = $request->input('order');

    $query = Product::query()->with('company');
    
    $priceOrder = $request->input('price_order');
    if ($priceOrder === 'asc') {
        $query->orderBy('price', 'asc');
    } else if ($priceOrder === 'desc') {
        $query->orderBy('price', 'desc');
    }

    $stockOrder = $request->input('stock_order');
    if ($stockOrder === 'asc') {
        $query->orderBy('stock', 'asc');
    } else if ($stockOrder === 'desc') {
        $query->orderBy('stock', 'desc');
    }

    $products = $query->get();

    return response()->json($products);
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       $products = Product::all();
       $companies = Company::all();

       return view('regists',compact('products','companies'));


       // ->with('products',$products)
        //->with('companies',$companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

public function store(Request $request)
{
    Company::select('company_name')->get();

    $request->validate([
        'product_name' => 'required',
        'price' => 'required',
        'stock' => 'required',
        'comment' => 'nullable',
        'company_name' => 'required',
        'img_path' => 'nullable'
    ]);
    if ($request->hasFile('img_path')) {
        $path = $request->file('img_path')->store('img', 'public');
    } else {
        $path = null;
    }
  
    $company = Company::firstOrCreate(['company_name' => $request->input('company_name')]);

    $product = new Product([
        'product_name' => $request->input('product_name'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'comment' => $request->input('comment'),
        'img_path' => $path,
    ]);

    if (isset($path)) {
        $product->img_path = $path;
    }

    $product->company()->associate($company);
    $product->save();

    return redirect()->route('products');
}


public function purchase(Request $request)
{
    $request->validate([
        'id' => 'required',
        'stock' => 'required',
    ]);
    $productId = $request->input('id');
    $stock = $request->input('stock');

    DB::beginTransaction();

    try {
        $product = Product::findOrFail($productId);

        if ($product->stock < $stock) {
         return response()->json(['message' => '購入できません。在庫不足です。']);
    }
        $product->stock -= $stock;
        $product->save();

        $purchase = new Purchase();
        $purchase->product_id = $product->id;
        $purchase->stock = $stock;
        $purchase->save();

    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => '購入処理を中断しました。'], 500);
    }
    
    DB::commit();

    return response()->json(['message' => '購入が完了しました。']);

}





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $companies,$id)
    {
        $products = Product::findOrFail($id);
        $companies = $products->company;

       // $companies = Company::with('products')->get();
       
       return view('show',compact('companies','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $companies,$id)
    {

        //会社名のみを表示したい
       // $companies = companies::findOrFail($id);
       $products = Product::findOrFail($id);
       $companies = Company::all();

        return view('edit')->with(['product' => $products,'companies' => $companies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $products,$id)
    {

        $product = Product::find($id);


        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'required',
        ]);


        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');

        $company = Company::firstOrCreate(['company_name' => $request->input('company_name')]);
        $product->company()->associate($company);
    
        $product->save();

        return redirect()->route('products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        DB::beginTransaction();
        try{
            $products = product::findOrFail($id);
            $products->delete();

            DB::commit();
            return response()->json(['message' => '削除しました。']);

        }catch(\Exeption $e){
            DB::rollback();
            return response()->json(['massage' => '処理を中断しました']);
        }
       
    }
}