<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLists(Request $request)
    {
        $product = Company::all();
        $query = Product::query()->with('company');
    
        $searchword = $request->input('searchword');
        $companyName = $request->input('company_name');
    
        if (!empty($searchword)) {
            $query->where('company_id', 'LIKE', "%{$searchword}%")
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
    
        // Get all products based on search and filters
        $products = $query->orderBy('id', 'desc')->get();
    
        // Fetch all companies to populate the company_name dropdown
        $companies = Company::all();
    
        return view('products', compact('products', 'companies', 'searchword', 'companyName'));
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
        $products = product::findOrFail($id);
        $products->delete();
       
        return redirect()->route('products');
    }
}