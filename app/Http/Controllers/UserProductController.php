<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
class UserProductController extends PageController
{

    public function display($category_id)
    {
    	$product=ProductModel::where('id',$category_id)->where('product_status','3')->get();
    	return view('frontend.pages.product',['product'=>$product]);
    }
}
