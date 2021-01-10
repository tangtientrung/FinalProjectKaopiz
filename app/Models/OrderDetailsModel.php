<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailsModel extends Model
{
    use HasFactory;
    public $timestamps = false;
 	protected $table = 'order_detail';
 	public function product()
    {
    	return $this->belongsTo('App\Models\ProductModel','product_id','id');
    }
}
