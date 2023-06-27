<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLists(Request $request)
    {
      $products = product::latest()->get();
      
      $products = product::all();
      $companies = company::all();



//検索機能

      $searchword = $request->input('searchword');
      $companies = $request->input('company_id');

        $query = product::query();

     if(!empty($searchword))
    {
        $query->where('company_id','LIKE',"%{$searchword}%");
        $query->orWhere('product_name','LIKE',"%{$searchword}%");
        $query->orWhere('price','LIKE',"%{$searchword}%");
        $query->orWhere('stock','LIKE',"%{$searchword}%");
        $query->orWhere('comment','LIKE',"%{$searchword}%");
    }
    if(!empty($companies)){
        $query->where('company_id',$companies)->get();
    }
    // 全件取得 
    $products = $query->orderBy('id','desc')->get();
   // $companies = $query->orderBy('company_id')->get();
    return view('products')->with('products',$products)->with('companies',$companies)->with('searchword',$searchword);
       // return view('products', compact('products', 'searchword'));
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

           //画像ファイルを取得し保存
        /*$img = $request->file('img_path');

        if(isset($img)){
            $path = $img->store('img','public');
            if($path){
                Products::create([
                    'img_path' => $path,
                ]);
            }
        }*/
        //only リクエストをまとめて受け取る
        $request = $request->only(['product_name','price','stock','company_name']);

        Product::create($request);
        Company::create($request);
       
        return redirect()->route('products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $companies = Company::findOrFail($id);
        $products = Product::with('company')->get();
        $products = Product::all();

        return view('show')
            ->with(['products' => $products,'companies' => $companies]);
      /* $products = Product::findOrFail($id);
       $companies = Company::with('Company')->get();

        return view('show',['companies' => $companies,'products' => $products]); 
    */

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(company $companies,$id)
    {

        //会社名のみを表示したい
       // $companies = companies::findOrFail($id);
       $products = product::findOrFail($id);
       $company = company::where('company_name')->get();

        return view('edit')->with(['product' => $products,'companies' => $company]);


     // return view('edit',compact('products','companies'));
                //,compact('products','companies'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'required',
        ]);


        $products = new products();
        $products->product_name = $request->product_name;
        $products->price = $request->price;
        $products->stock = $request->stock;
        $products->comment = $request->comment;
        $products->save();

        return redirect()
            ->route('products', $products);
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
