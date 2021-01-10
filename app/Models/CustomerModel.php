<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'customer_email',  'customer_password',  'customer_name','customer_phone','status'
    ];
    //protected $primaryKey = 'customer_id';
 	protected $table = 'customer';
 	public function xa()
    {
    	return $this->belongsTo('App\Models\WardsModel','xaid','xaid');
    }
    public function qh()
    {
    	return $this->belongsTo('App\Models\DistrictModel','maqh','maqh');
    }
    public function tp()
    {
    	return $this->belongsTo('App\Models\ProvinceModel','matp','matp');
    }
}
