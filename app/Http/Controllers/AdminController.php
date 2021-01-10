<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\AnalystModel;
use DB;
class AdminController extends Controller
{
    public function dashboard()
    {
    	$dau_thang=Now('Asia/Ho_Chi_Minh')->startOfMonth();
    	$cuoi_thang=Now('Asia/Ho_Chi_Minh')->endOfMonth();
    	$customer=CustomerModel::whereBetween('created_at', [$dau_thang, $cuoi_thang])->get();
    	$order=OrderModel::whereBetween('created_at', [$dau_thang, $cuoi_thang])->where('order_status','Đã giao')->get();
        $order_total=OrderModel::whereBetween('created_at', [$dau_thang, $cuoi_thang])->get();
    	$month= date('m');
    	//$year=date('Y');
    	$new_product=count(ProductModel::whereBetween('created_at', [$dau_thang, $cuoi_thang])->get());
    	$product_sell =DB::table('order_detail')
             			->select(DB::raw('sum(product_sales_quantity) as sale '))->whereBetween('created_at', [$dau_thang, $cuoi_thang])->get();
        foreach ($product_sell as $key => $value) {
    		foreach ($value as $key1 => $value1) {
    			$product_sell=$value1;
    		}
    	}
		$product_in_store =DB::table('product')
             			->select(DB::raw('sum(product_qty) as sale '))->whereBetween('created_at', [$dau_thang, $cuoi_thang])->get();
    	foreach ($product_in_store as $key => $value) {
    		foreach ($value as $key1 => $value1) {
    			$product_in_store=$value1;
    		}
    	}

      $most_view=ProductModel::orderBy('product_view','DESC')->take(5)->get();
    	
    	 //var_dump($new_product);
    	//echo ($product_in_store);
    	//echo $dau_thang;
    	 return view('admin.pages.dashboard')->with(compact('customer','month','order','order_total','new_product','product_sell','product_in_store','most_view'));
    }

    public function filter(Request $request)
    {
        $analyst=AnalystModel::whereBetween('order_date', [$request->begin, $request->end])->get();
        foreach ($analyst as $key => $val) {
            $chart[]=array(
                'date' => $val->order_date,
                'order_qty' => $val->order_qty,
                'sales' => $val->sales,
                'coupon' => $val->coupon,
                'profit' => $val->profit );
        }
        // foreach ($analyst as $key => $val) {
        //     $chart[]=array(
        //         'year' => $val->order_date,
        //         'value' => $val->order_qty);
        // }
        return json_encode($chart) ;
        //echo $chart;
    }
    public function filterMonth(Request $request)
    {
        $dau_thang=Now('Asia/Ho_Chi_Minh')->startOfMonth();
        $cuoi_thang=Now('Asia/Ho_Chi_Minh')->endOfMonth();
        $analyst=AnalystModel::whereBetween('order_date', [$dau_thang, $cuoi_thang])->get();
        foreach ($analyst as $key => $val) {
            $chart[]=array(
                'date' => $val->order_date,
                'order_qty' => $val->order_qty,
                'sales' => $val->sales,
                'coupon' => $val->coupon,
                'profit' => $val->profit );
        }
        // foreach ($analyst as $key => $val) {
        //     $chart[]=array(
        //         'year' => $val->order_date,
        //         'value' => $val->order_qty);
        // }
        return json_encode($chart) ;
        //echo $chart;
    }

    public function box(Request $request)
    {
        $begin=$request->begin;
        $end=$request->end;
        $customer=CustomerModel::whereBetween('created_at', [$begin, $end])->get();
        $order=OrderModel::whereBetween('created_at', [$begin, $end])->where('order_status','Đã giao')->get();
        $order_total=OrderModel::whereBetween('created_at', [$begin, $end])->get();
        echo '<div class="row filter-dashboard">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>'.count($order).'</h3>
                <p>Đơn đặt hàng hoàn thành</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="admin/don-hang/moi" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>'.count($order_total).'</h3>
                <p>Tổng đơn hàng</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/admin/dashboard" class="small-box-footer">Chi tiết<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>'.count($customer).'</h3>
                <p>Khách hàng mới</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="/admin/dashboard" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>
                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="/admin/dashboard" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          </div>
       ';
        
    }
}
