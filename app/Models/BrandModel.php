<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    use HasFactory;
    protected $table ="brand";
    public function product()
    {
    	return $this->hasMany('App\Models\ProductModel','brand_id','id');
    }
    public function categoryDetails()
    {
    	return $this->belongsTo('App\Models\SubCategoryModel','sub_category_id','id');
    }
}
