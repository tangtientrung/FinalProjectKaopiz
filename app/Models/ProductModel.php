<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table ="product";
    public function category()
    {
    	return $this->belongsTo('App\Models\CategoryModel','category_id','id');
    }
    public function sub_category()
    {
        return $this->belongsTo('App\Models\SubCategoryModel','sub_category_id','id');
    }
    public function brand()
    {
    	return $this->belongsTo('App\Models\BrandModel','brand_id','id');
    }
}
