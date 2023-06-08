<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    //protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable =['company_id','product_name','price','stock','comment','img_path'];

    public function companies()
    {
        return $this->belongsTo(Companies::class);
    }


    /*public function companies(){
        return $this->belongTo(Companies::class);
        //Companiesに対して1:多数の関係を定義

    }*/

}
