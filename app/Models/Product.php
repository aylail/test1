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
    
    protected $fillable =['id','company_id','product_name','price','stock','comment','img_path'];
    public $sortable = ['company_id','product_name','price','stock','comment','img_path'];
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
    public function purchases()
{
    return $this->hasMany(Purchase::class, 'product_id'); 
}

}
