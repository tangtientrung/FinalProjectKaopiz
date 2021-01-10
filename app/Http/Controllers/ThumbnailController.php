<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ThumbnailModel;
use Illuminate\Support\Str;
class ThumbnailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product=ProductModel::all();
        return view('admin.pages.thumbnail.add')->with(compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request,[
            'image'=>'required',
        ],
        [
            'image.required'=>'Bạn chưa chọn hình ảnh',
        ]);
            $thumbnail=new ThumbnailModel;
            $file=$request->file('image');

            //check file hop le
            $duoi=$file->getClientOriginalExtension();
            if($duoi!='jpg'&& $duoi!='png' && $duoi!='jpeg')
            {
                return redirect('admin/thumbnail/them')->with('errors','Bạn chỉ được chọn file có đuôi png,jpg,jpeg');
            }

            //luu anh
            $name=$file->getClientOriginalName();
            do
            {
                $hinh=Str::random(3)."_".$name;
            }
            while (file_exists("img/thumbnail".$hinh));
            $file->move("img/thumbnail",$hinh);
            $thumbnail->link=$hinh;
            $thumbnail->product_id=$request->product;
            $thumbnail->status=$request->status;
            $thumbnail->save();
            return redirect('admin/thumbnail/them')->with('thongbao','Thêm thumbnail thành công');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
