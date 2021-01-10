<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\OrderDetailsModel;
use App\Models\OrderModel;
class NotificationController extends Controller
{
    public function notification()
    {
    	$order=OrderModel::where('order_status','Đang xử lí')->get();
    	var_dump($order);
    	//return
    }
}
