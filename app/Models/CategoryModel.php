<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table ="category";
    /*public function product()
    {
    	return $this->hasManyThrough('App\Models\ProductModel','App\Models\CategoryDetailsModel','category_id','category_details_id','id');
    }*/
   
    public function sub_category()
    {
        return $this->hasMany('App\Models\SubCategoryModel','category_id','id');
    }
    public function product()
    {
        return $this->hasMany('App\Models\ProductModel','category_id','id');
    }
}
