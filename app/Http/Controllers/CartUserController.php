<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use Cart;
class CartUserController extends PageController
{
    public function show_cart()
    {
    	return view('frontend.pages.show_cart');
    }
    public function add_to_cart(Request $request)
    {
    	// $product=ProductModel::find($request->id_product);
    	// Cart::add([
    	// 	'id' => $product->id,
    	// 	'name' => $product->product_name,
    	// 	'qty' => $request->quantity,
    	// 	'price' => $product->product_price,
    	// 	'weight' => 0,
    	// 	'options' =>[
    	// 					'image' => $product->product_image
    	// 				]
    	// 		]);
    			//Cart::destroy();
        Cart::add([
         'id' => $request->product_id,
         'name' => $request->product_name,
         'qty' => $request->product_qty,
         'price' => $request->product_price,
         'weight' => 0,
         'options' =>[
                         'image' => $request->product_image,
                     ]
             ]);
        //return $request->all();
    	//return redirect('/gio-hang');
    }
    public function update_quantity(Request $request)
    {
    	$rowId=$request->rowId;
    	$new_qty=$request->quantity;
    	Cart::update($rowId, $new_qty);
    	return redirect('/gio-hang'); 
    }
    public function delete(Request $request)
    {
    	$rowId=$request->rowId_delete;
    	Cart::remove($rowId);
    	return redirect('/gio-hang');
    }
}

