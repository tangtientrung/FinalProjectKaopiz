<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProvinceModel;
use App\Models\DistrictModel;
use App\Models\WardsModel;
use App\Models\FeeShipModel;
use App\Models\CouponModel;
use Cart;
use Session;
class CouponController extends PageController
{
	public function check(Request $request)
	{
		$coupon_code=$request->coupon_code;
        $discount=0;
        $number_discount=0;
        //echo $coupon_code;
		$coupon_db=CouponModel::where('coupon_code',$coupon_code)->first();
		if(!$coupon_db)
		{
			return redirect('/gio-hang')->with('coupon_err','Mã giảm giá không hợp lệ');
		}
		else
		{	
            $coupon= Session::get('coupon');

            if(!$coupon)
            {
                 Session::put('number_discount',$number_discount);
                 $coupon_db->coupon_time=$coupon_db->coupon_time-1;
                 $coupon_db->save();
                if($coupon_db->coupon_condition==1)
                {
                    $discount=(int)((int)(implode('',explode(',', Cart::subtotal())))/($coupon_db->coupon_number));
                }
                else if($coupon_db->coupon_condition==2)
                {
                    $discount=$coupon_db->coupon_number;
                }
                $coupon[] = array(
                    '0'=>array(
                        'coupon_code' => $coupon_db->coupon_code,
                        'coupon_condition' => $coupon_db->coupon_condition,
                        'coupon_number' => $discount,
                    )
                
                
                );
                Session::put('coupon',$coupon);

                foreach ($coupon as $key=>$value) {
                        foreach ($value as $key1 => $value1) 
                            {
                                $number_discount+=$value1['coupon_number'];
                                
                            }   
                    }
            Session::put('number_discount',$number_discount);
                return redirect('/gio-hang')->with('message','Thêm mã giảm giá thành công');
            }
            else
            {
                $check=0;
                foreach ($coupon as $key=>$value) {
                    foreach ($value as $key1 => $value1) 
                        {
                            if($value1['coupon_code']==$coupon_code)
                            {
                                $check=1;
                                break;
                            }
                        }   
                }
                if($check==1)
                {
                    return redirect('/gio-hang')->with('coupon_err','Mã giảm giá trùng');
                }
                else
                {
                    $coupon_db->coupon_time=$coupon_db->coupon_time-1;
                 $coupon_db->save();
                    $count=count(Session::get('coupon'));
                    if($coupon_db->coupon_condition==1)
                    {
                        $discount=(int)((int)(implode('',explode(',', Cart::subtotal())))/($coupon_db->coupon_number));
                    }
                    else if($coupon_db->coupon_condition==2)
                    {
                        $discount=$coupon_db->coupon_number;
                    }
                    $add_coupon=array(
                        $count=>array(
                            'coupon_code' => $coupon_db->coupon_code,
                            'coupon_condition' => $coupon_db->coupon_condition,
                            'coupon_number' => $discount,
                        ));
                    array_push($coupon, $add_coupon);
                    Session::put('coupon',$coupon);
                   
                    foreach ($coupon as $key=>$value) {
                            foreach ($value as $key1 => $value1) 
                                {
                                    $number_discount+=$value1['coupon_number'];
                                    
                                }   
                        }
                    Session::put('number_discount',$number_discount);
                    return redirect('/gio-hang')->with('message','Thêm mã giảm giá thành công');
                }
                
                
            }

            
                
        }
	}	



    public function cancel($id)
    {
        $coupon=session('coupon');
        $number_discount=session('number_discount');
        $number=0;
        $coupon_code="";
        foreach ($coupon as $key=>$value) {
                            foreach ($value as $key1 => $value1) 
                                {
                                    if($key1==$id)
                                    {
                                        $number=$value1['coupon_number'];
                                        $coupon_code=$value1['coupon_code'];
                                    }
                                   
                                    
                                }   
        }
        $number_discount=$number_discount-$number;
        Session::put('number_discount',$number_discount);
        unset($coupon[$id]);
        Session::put('coupon',$coupon);

        $coupon_db=CouponModel::where('coupon_code',$coupon_code)->first();
        $coupon_db->coupon_time=$coupon_db->coupon_time+1;
        $coupon_db->save();
        return redirect('/gio-hang')->with('message','Hủy mã giảm giá thành công');
    }

		

	//admin
    public function add()
    {
        return view('admin.pages.coupon.add');
    }	
	
}
