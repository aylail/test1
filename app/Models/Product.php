<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory,Sortable;

    protected $table = 'products';
    protected $primaryKey = 'id';
    
    protected $fillable =['company_id','product_name','price','stock','comment','img_path'];
    public $sortable = ['company_id','product_name','price','stock','comment','img_path'];
    public function company()
    {
        $products = Product::get()->sortBy('desc');
        return $this->belongsTo(Company::class,'company_id');
    }

}
