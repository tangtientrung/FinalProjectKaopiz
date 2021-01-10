<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\ProductModel;
use App\Models\AnalystModel;
use Carbon\Carbon;
use PDF;
class OrderController extends Controller
{
    public function newOrder()
    {
    	$new_order=OrderModel::where('order_status','Đang xử lí')->paginate(5);
    	return view('admin.pages.order.new_order')->
    	with(compact('new_order'));
    }
    public function confirmOrder($id)
    {

    	$order=OrderModel::find($id);
    	if($order->order_status=="Đang xử lí")
    	{
    		$order->order_status="Đang giao hàng";
	    	$order->save();
	    	$new_order=OrderModel::where('order_status','Đang xử lí')->paginate(5);
	    	$order_code=$order->order_code;
	    	$success='Xác nhận đơn hàng '.$order_code.' thành công';
	    	return redirect('admin/don-hang/don-hang-moi')->
	    	with(compact('new_order','success'));
    	}
    	else
    	{
    		$order->order_status="Đã giao";
	    	$order->save();
	    	$shipping_order=OrderModel::where('order_status','Đang giao hàng')->paginate(5);
	    	$order_code=$order->order_code;
	    	$success='Xác nhận đơn hàng '.$order_code.' thành công';
	    	return redirect('admin/don-hang/don-hang-dang-giao')->
	    	with(compact('shipping_order','success'));
    	}
    	


    	// $id=$request->order_id;
    	// $order=OrderModel::find($id);
    	// $order->order_status="Đã xác nhận";
    	// $order->save();
    	
    }
    public function confirmOrderPost(Request $request)
    {
    	$id=$request->order_id;
    	$order=OrderModel::find($id);
    	$order->order_status="Đã xác nhận";
    	$order->save();
    	$new_order=OrderModel::where('order_status','Đang xử lí')->get();
    	echo $new_order;
    	//echo "a";
    	
    }
    public function detail($id)
    {
    	$order_view=OrderModel::find($id);
    	return view('admin.pages.order.detail')->
    	with(compact('order_view'));
    }
    public function shippingOrder()
    {
    	$shipping_order=OrderModel::where('order_status','Đang giao hàng')->paginate(5);
    	return view('admin.pages.order.shipping')->
    	with(compact('shipping_order'));
    }
    public function successOrder($id)
    {
    	$order=OrderModel::find($id);
    	$order->order_status="Đã giao";
    	$order->save();
    	$shipping_order=OrderModel::where('order_status','Đang giao hàng')->paginate(5);
    	$order_code=$order->order_code;
    	$success='Xác nhận đơn hàng '.$order_code.' thành công';


        //analyst
        $order_date=$order->created_at->toDateString();
        $now=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $analyst=AnalystModel::where('order_date',$order_date)->first();

        //add db
        $order_detail=OrderDetailsModel::where('order_code',$order->order_code)->get();
        $coupon=$order->order_coupon;
        $sales=0;
        $profit=0;
        foreach ($order_detail as $od) {
            $product=ProductModel::where('id',$od->product_id)->first();
            $price=0;
            if(isKM($product->bdkm,$product->ktkm))
            {
                $price=$product->product_price_km;
            }
            else
            {
                $price=$product->product_price;
            }
            $import=$product->product_import;

            $sales+=$od->product_sales_quantity*$price;
            $profit+=$od->product_sales_quantity*$price-$od->product_sales_quantity*$import;
        }
        $profit=$profit-$coupon;

        //check isset
        if($analyst)
        {
            $analyst->sales=$analyst->sales+$sales;
            $analyst->profit=$analyst->profit+$profit;
            $analyst->coupon=$analyst->coupon+$coupon;
            $analyst->order_qty=$analyst->order_qty+1;
            $analyst->save();
        }
        else
        {
            $new_analyst=new AnalystModel;
            $new_analyst->sales=$sales;
            $new_analyst->profit=$profit;
            $new_analyst->coupon=$coupon;
            $new_analyst->order_qty=1;
            $new_analyst->order_date=$order_date;
            $new_analyst->save();
        }
    	return redirect('admin/don-hang/don-hang-dang-giao')->
    	with(compact('shipping_order','success'));

    }
    public function order()
    {
    	$success_order=OrderModel::where('order_status','Đã giao')->paginate(5);
    	return view('admin.pages.order.success')->
    	with(compact('success_order'));
    }
    public function print($id)
    {
    	$order_view=OrderModel::find($id);
    	return view('admin.pages.order.print_order')->
    	with(compact('order_view'));
    }
    public function pdfview($id)
    {
        $order_view=OrderModel::find($id);
        view()->share('order_view',$order_view);
        $pdf = PDF::loadView('admin.pages.order.print_order');
        $pdf->download('pdfview.pdf');
        return view('admin.pages.order.print_order');
    }

    public function inMonth()
    {
        $dau_thang=Now('Asia/Ho_Chi_Minh')->startOfMonth();
        $cuoi_thang=Now('Asia/Ho_Chi_Minh')->endOfMonth();
        $success_order=OrderModel::whereBetween('created_at', [$dau_thang, $cuoi_thang])->where('order_status','Đã giao')->paginate(5);
        //var_dump($success_order);
        return view('admin.pages.order.success')->
        with(compact('success_order'));
    }
}
