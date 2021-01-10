<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    
   	use HasFactory;
 	protected $table = 'order';
 	public function orderDetails()
    {
    	return $this->hasMany('App\Models\OrderDetailsModel','order_code','order_code');
    }
    public function shipping()
    {
    	return $this->hasOne('App\Models\ShippingModel','id','shipping_id');
    }
    public function customer()
    {
    	return $this->belongsTo('App\Models\CustomerModel','customer_id','id');
    }
}
