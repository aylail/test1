<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';


 /*   public function detail()
    {
        $companies = companies::all();
        return $companies;
    }*/
    public function products()
    {
        return $this->hasMany(Products::class);
    }
    protected $fillable = ["company_name","street_address","representative_name"];
}
