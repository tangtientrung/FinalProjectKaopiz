<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CouponModel;
class CouponAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon=CouponModel::orderBy('created_at','ASC')->paginate();
        return view('admin.pages.coupon.display')->with(compact('coupon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.coupon.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            ['name'=>'required',
            'time'=>'required',
            'code'=>'required|unique:coupon,coupon_code',
            'number'=>'required',
            'condition'=>'required',
            ],
            [
                
                'name.required'=>'Tên mã giảm giá không được để trống',
                'time.required'=>'Số lần sử dụng không được để trống',
                'code.required'=>'Mã giảm giá không được để trống',
                'number.required'=>'Số tiền|Số phần trăm không được để trống',
                'condition.required'=>'Điều kiện không được để trống',
                'code.unique'=>'Mã giảm giá đã tồn tại',
        ]);
        $coupon=new CouponModel;
        $coupon->coupon_name=$request->name;
        $coupon->coupon_code=$request->code;
        $coupon->coupon_number=$request->number;
        $coupon->coupon_condition=$request->condition;
        $coupon->coupon_time=$request->time;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $coupon->created_at = now();
        $coupon->updated_at = now();
        $coupon->save();
        return redirect('admin/ma-giam-gia/them')->with('thongbao','Thêm mã giảm giá thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon=CouponModel::find($id);
        return view('admin.pages.coupon.edit')->with(compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request,
            ['name'=>'required',
            'time'=>'required',
            'code'=>'required|unique:coupon,coupon_code',
            'number'=>'required',
            'condition'=>'required',
            ],
            [
                
                'name.required'=>'Tên mã giảm giá không được để trống',
                'time.required'=>'Số lần sử dụng không được để trống',
                'code.required'=>'Mã giảm giá không được để trống',
                'number.required'=>'Số tiền|Số phần trăm không được để trống',
                'condition.required'=>'Điều kiện không được để trống',
                'code.unique'=>'Mã giảm giá đã tồn tại',
        ]);
        $coupon=CouponModel::find($id);
        $coupon->coupon_name=$request->name;
        $coupon->coupon_code=$request->code;
        $coupon->coupon_number=$request->number;
        $coupon->coupon_condition=$request->condition;
        $coupon->coupon_time=$request->time;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $coupon->updated_at = now();
        $coupon->save();
        return redirect('admin/ma-giam-gia/sua/'.$id)->with('thongbao','Cập nhật mã giảm giá thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon=CouponModel::find($id);
        $thongbao="Xóa mã giảm giá ".$coupon->coupon_code." thành công";
        $coupon->delete();
        $coupon=CouponModel::orderBy('created_at','ASC')->paginate();
        return view('admin.pages.coupon.display')->with(compact('coupon','thongbao'));
    }
}
