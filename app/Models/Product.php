<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    
    protected $fillable =['company_id','product_name','price','stock','comment','img_path'];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

}
