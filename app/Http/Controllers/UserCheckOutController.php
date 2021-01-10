<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\Captcha; 
use Session;
use App\Models\SocialModel; //sử dụng model Social
use Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerModel;
use App\Models\FeeShipModel;
use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\ShippingModel;
use App\Models\ProductModel;
use App\Models\ProvinceModel;
use App\Models\DistrictModel;
use App\Models\WardsModel;
use Cart;
class UserCheckOutController extends PageController
{
     public function checkout()
    {
    	if(session()->has('customer_id'))
    	{
            $tinh_thanh_pho=ProvinceModel::all();
            $customer=CustomerModel::find(Session::get('customer_id'));
            $xaid="";
            $maqh="";
            $matp="";
            if($customer->xaid!=0|$customer->maqh!=0|$customer->matp!=0)
            {
                    $xaid=$customer->xaid;
                    $maqh=$customer->maqh;
                    $matp=$customer->matp;
            }
            //var_dump($tinh_thanh_pho);
    		return view('frontend.pages.checkout',
                ['tinh_thanh_pho'=>$tinh_thanh_pho,
                'xaid'=>$xaid,
                'maqh'=>$maqh,
                'matp'=>$matp,
                'customer'=>$customer,
                ]);
    	}
    	else
    	{
    		return redirect('/thanh-toan/dang-nhap');
    	}
    }
    public function payment(Request $request)
    {
        echo $request->name;
    }
    public function confirm_shipping(Request $request)
    {
        $fee="";
        //user co thong tin
        $province=$request->matp_available;
        $district=$request->maqh_available;
        $wards=$request->xaid_available;
        $this->validate($request,
            [
                'name'=>'required',
                'phone'=>'required',
                'payment'=>'required',
            ],
            [
                'name.required'=>'Bạn phải nhập họ tên',
                'phone.required'=>'Bạn phải nhập số điện thoại',
                'payment.required'=>'Bạn phải chọn phương thức thanh toán',
            ]);
        
        //validate TH thay doi thong tin
        if($request->xaid|$request->maqh|$request->matp)
        {
            $this->validate($request,
            [
                
                'matp'=>'required',
                'maqh'=>'required',
                'xaid'=>'required',
            ],
            [
               
                'matp.required'=>'Bạn phải chọn tỉnh/thành phố',
                'maqh.required'=>'Bạn phải chọn quận/huyện',
                'xaid.required'=>'Bạn phải chọn xã/phường/thị trấn',
                
            ]);
            //echo "co";
            $fee=FeeShipModel::where('fee_matp',$request->matp)->where('fee_maqh',$request->maqh)->where('fee_xaid',$request->xaid)->first();
            //user khong co thong tin
            $province=$request->matp;
            $district=$request->maqh;
            $wards=$request->xaid;
        }

        //validate TH ko co thong tin
        if(!$request->xaid_available|!$request->maqh_available|!$request->matp_available)
        {
            $this->validate($request,
            [
                
                'matp'=>'required',
                'maqh'=>'required',
                'xaid'=>'required',
            ],
            [
               
                'matp.required'=>'Bạn phải chọn tỉnh/thành phố',
                'maqh.required'=>'Bạn phải chọn quận/huyện',
                'xaid.required'=>'Bạn phải chọn xã/phường/thị trấn',
                
            ]);
        }

        $fee=FeeShipModel::where('fee_matp',$request->matp_available)->where('fee_maqh',$request->maqh_available)->where('fee_xaid',$request->xaid_available)->first();
        //tinh tien ship
        if($fee)
        {
            $fee_ship=$fee->fee_feeship;
            $money=(int)(implode('',explode(',', Cart::subtotal())))+$fee_ship;
        }
        else
        {
            $fee_ship=(int)20000;
            $money=(int)(implode('',explode(',', Cart::subtotal())))+$fee_ship;
        }

        //tinh tien coupon
        $money=$money-session('number_discount');

        
    $payment_method=$request->payment;
    $name=$request->name;
    $phone=$request->phone;
    $coupon=session('number_discount');
    return view('frontend.pages.review_payment',
        [
            'fee_ship'=>$fee_ship,
            'money'=>$money,
            'coupon'=>$coupon,
            'payment_method'=>$payment_method,
            'note'=>$request->note,
            //'product'=>$product,
            'province'=>$province,
            'district'=>$district,

            'wards'=>$wards,
            'name'=>$name,
            'phone'=>$phone,

        ]);
         

    }
    public function buying(Request $request)
    {
        //$product_str=$request->product;
        /*$product_arr=explode('|', $product_str);
        //var_dump(trim($product_arr));
        $n=count($product_arr);
        //echo($n);
        $product=array()  ;
         //$i=0; 
        for ($i=0;$i<=$n-2;$i=$i+3) {
            $product[$i]=array(
                'product_id'=>$product_arr[$i],
                'product_name'=>$product_arr[$i+1],
                'product_qty'=>$product_arr[$i+2]
            );
            //$i++;*/
            //echo $i;
        //}
        $code=Str::random(10);

        //lay dia chi giao hang
        $province_id=$request->province;
        $province=ProvinceModel::where('matp',$province_id)->first();
        
        $district_id=$request->district;
        $district=DistrictModel::where('maqh',$district_id)->first();
        $wards_id=$request->wards;
        $wards=WardsModel::where('xaid',$wards_id)->first();
        
        //new shipping
        $shipping=new ShippingModel;
        $shipping->shipping_name=$request->name;
        $shipping->shipping_phone=$request->phone;
        $shipping->shipping_address=$wards->name_xaphuong.", ".$district->name_quanhuyen.", ".$province->name_city;
        $shipping->shipping_notes=$request->note;
        $shipping->shipping_method=$request->payment_method;
        $shipping->save();


        //new order
        $shipping_id=$shipping->id;
        $order=new OrderModel;
        $order->customer_id=Session::get('customer_id');
        $order->order_total=$request->money;
        $order->order_feeship=$request->fee_ship;
        $order->order_status="Đang xử lí";
        $order->order_code=$code;
        $order->shipping_id=$shipping_id;
        $order->order_payment=$request->payment;
        $order->order_coupon=$request->coupon;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        //new order_details
        foreach (Cart::content() as $c) {
            $order_details=new OrderDetailsModel;
            $order_details->product_id=$c->id;
            $order_details->product_name=$c->name;
            $order_details->product_sales_quantity=$c->qty;
            $order_details->product_price=$c->price;
            $order_details->product_image=$c->options['image'];       
            $order_details->order_code=$code;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order_details->created_at = now();
            $order_details->save();
            $product=ProductModel::where('id',$c->id)->first();
            $product->product_qty=$product->product_qty-$c->qty;
            $product->save();
        }
        
        Cart::destroy();
        Session::forget('coupon');
        Session::forget('number_discount');
        return redirect('/');
        //var_dump($request->payment_method);

    }
    public function view_order()
    {
        $customer_id=Session::get('customer_id');
        //$order=DB::select('select id, count(order_code)  from tbl_order where customer_id = '. $customer_id.' group by id' );
        $order=OrderModel::where('customer_id',$customer_id)->get();
        // if(count($order)>0)
        // {
        //     foreach ($order as $o) {
        //     $order_details=OrderDetailsModel::where('order_code',$o->order_code);
        //     $shipping=ShippingModel::where('id',$o->shipping_id);
        //                         }
        // }
        
        return view('frontend.pages.view_order',
            [   'order'=>$order
                // 'order_details'=>$order_details,
                // 'shipping'=>$shipping
            ]);
    }
}
