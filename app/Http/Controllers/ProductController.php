<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Companies;
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
      $products = products::latest()->get();
     // return view('products',compact('products'));
      
      $products = products::all();
      $companies = companies::all();

//検索機能
      $searchword = $request->input('searchword');
      $companies = $request->input('company_id');

        $query = products::query();

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
    return view('products')->with('products',$products,$companies)->with('searchword',$searchword);
       // return view('products', compact('products', 'searchword'));

    }

    //検索機能
   /* public function searchWord(Request $request)
    {
        $searchword = $request->input('searchword');

        $query = products::query();

        if(!empty($searchword)) {
            $query->where('company_id', 'LIKE', "%{$searchword}%");
               // ->orWhere('', 'LIKE', "%{$searchword}%");
        }

        $products = $query->get();

        $copmanies = $companies->company_name()->where('companies')->get();


        return view('searchword', compact('products', 'searchword'));
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('regists');

       /* $products = Products::all();
        $companies = Companies::all();
s
        ->with('products',$products)
        ->with('companies',$companies);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'required',
            'img_path' => 'image'
        ]);

           //画像ファイルを取得し保存
        $img = $request->file('img_path');

        if(isset($img)){
            $path = $img->store('img','public');
            if($path){
                Products::create([
                    'img_path' => $path,
                ]);
            }
        }
      
  


        Products::create($request->all());
       
        return redirect()->route('products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companies = Companies::findOrFail($id);//where("company_name","street_address","representative_name");
        return view('show')->with(['companies' => $companies]);
       // $companies = Companies::latest()->get();
        //return view('show',compact('companies'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Companies $companies, $id)
    {
        //会社名のみを表示したい
        $companies = Companies::get();
        $products = products::findOrFail($id);

        return view('edit',compact('products','companies'));

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
        $products = products::findOrFail($id);
        $products->delete();
       
        return redirect()->route('products');
    }
}
