<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\CustomerModel;
use App\Models\ProvinceModel;
use Illuminate\Support\Str;


class UserController extends PageController
{
	public function account()
	{
		$id=Session::get('customer_id');
		$customer=CustomerModel::find($id);

		
		return view('frontend.pages.profile')->with(compact('customer'));
	}
	public function logout()
	{
		Session::forget('customer_id');
		Session::forget('customer_name');
		Session::forget('checkout');
		return redirect('/');	
	}
	public function editProfile()
	{
		$id=Session::get('customer_id');
		$customer=CustomerModel::find($id);
		$tp=ProvinceModel::all();
		$address="";
		if($customer->xaid!=0&&$customer->maqh!=0&&$customer->matp!=0)
		{
			$address=$customer->xa->name_xaphuong.' - '.$customer->qh->name_quanhuyen.' - '.$customer->tp->name_city;
		}
		
		return view('frontend.pages.edit_profile')->with(compact('customer','tp','address'));
	}
	public function postEditProfile(Request $request,$id)
	{
		$customer=CustomerModel::find($id);

		//check thay doi avatar
        $image=$customer->customer_avatar;
        if($request->image)
        {
            $this->validate($request,[
                'image'=>'required|mimes:jpeg,jpg,png',
            ],
            [
                'image.required'=>'Bạn chưa chọn hình ảnh',
                'image.mimes'=>'Hình ảnh chỉ được phép có đuôi jpeg|jpg|png',
            ]);
            $file=$request->file('image');
            //luu anh
            $name=$file->getClientOriginalName();
            do
            {
                $hinh=Str::random(3)."_".$name;
            }
            while (file_exists("img/avatar".$hinh));
            $file->move("img/avatar",$hinh);
            $image=$hinh;   
            $customer->customer_avatar=$image;
        }

        //check thay doi address
        if($request->xaid||$request->maqh||$request->matp)
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
            $customer->xaid=$request->xaid;
            $customer->maqh=$request->maqh;
            $customer->matp=$request->matp;
        }

        $this->validate($request,
            [
                'name'=>'required',
                'phone'=>'required',
            ],
            [
                'name.required'=>'Bạn phải nhập họ tên',
                'phone.required'=>'Bạn phải nhập số điện thoại',
            ]);
        
        $customer->customer_name=$request->name;
        $customer->customer_phone=$request->phone;
        $customer->save();

		$id=Session::get('customer_id');
		$customer=CustomerModel::find($id);
		$tp=ProvinceModel::all();
		$address="";
		if($customer->xaid!=0&&$customer->maqh!=0&&$customer->matp!=0)
		{
			$address=$customer->xa->name_xaphuong.' - '.$customer->qh->name_quanhuyen.' - '.$customer->tp->name_city;
		}
		$thongbao="Thành công";
		return view('frontend.pages.edit_profile')->with(compact('customer','tp','address','thongbao'));
	}

	public function changePW()
	{
		$id=Session::get('customer_id');
		$customer=CustomerModel::find($id);
		return view('frontend.pages.changePW')->with(compact('customer'));
		
	}
	public function postchangePW(Request $request)
	{
		$this->validate($request,
            [
                'pw'=>'required',
                'new_pw'=>'required',
                'confirm_pw'=>'required|same:new_pw',
            ],
            [
                'pw.required'=>'Bạn phải nhập mật khẩu cũ',
                'new_pw.required'=>'Bạn phải nhập mật khẩu mới',
                'confirm_pw.required'=>'Bạn phải nhập xác nhận mật khẩu mới',
                'confirm_pw.same'=>'Mật khẩu xác nhận sai',
            ]);
		$id=Session::get('customer_id');
		$customer=CustomerModel::find($id);
		if(md5($request->pw)==$customer->customer_password)
		{
			$customer->customer_password=md5($request->new_pw);
			$customer->save();
			
			$thongbao="Đổi mật khẩu thành công";
			return view('frontend.pages.changePW')->with(compact('thongbao','customer'));
		}
		else
		{

			$thongbao="Mật khẩu sai";
			return view('frontend.pages.changePW')->with(compact('thongbao','customer'));
		}
		
	}
	// public function checkCustomer()
	// {
	// 	return view ('frontend.pages.checkCustomer');
	// }
	// public function postCheckCustomer(Request $request)
	// {
	// 	$this->validate($request,
 //            [
 //                'pw'=>'required',
 //            ],
 //            [
 //                'pw.required'=>'Không được để trống',
                
 //            ]);
	// 	$id=Session::get('customer_id');
	// 	$customer=CustomerModel::find($id);
	// 	$thongbao="Vui lòng kiểm tra lại";
	// 	if(md5($request->pw)==$customer->customer_password)
	// 	{

	// 		return view ('frontend.pages.changePW');
	// 	}
	// 	else
	// 	{
			
	// 		return view('frontend.pages.checkCustomer')->with(compact('thongbao'));
	// 	}
	// }
}



