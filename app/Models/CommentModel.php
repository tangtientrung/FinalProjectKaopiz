<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;
    protected $table ="comment";
    public function customer()
    {
    	return $this->belongsTo('App\Models\CustomerModel','user_id','id');
    }
}
