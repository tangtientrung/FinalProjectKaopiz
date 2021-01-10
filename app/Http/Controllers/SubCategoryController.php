<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategoryModel;
use App\Models\CategoryModel;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_category=SubCategoryModel::orderBy('sub_category_status', 'desc')->orderBy('category_id', 'asc')->get();
        return view('admin.pages.sub_category.display',['sub_category'=>$sub_category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=CategoryModel::all();
        return view('admin.pages.sub_category.add',[
            'category'=>$category]);
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
            [
                'txtDanhMuc'=>'required',
                'txtDanhMucChiTiet'=>'required|min:3|max:100',
                'desc'=>'required',
            ],
            [
                'txtDanhMuc.required'=>'Bạn phải chọn danh mục',
                'txtDanhMucChiTiet.required'=>'Bạn phải điền vào tên danh mục chi tiết',
                'txtDanhMucChiTiet.min'=>'Tên danh mục chi tiết từ 3 đến 100 kí tự',
                'txtDanhMucChiTiet.max'=>'Tên danh mục chi tiết từ 3 đến 100 kí tự',
                'desc.required'=>'Bạn phải điền vào mô tả danh mục chi tiết',
            ]);
        $sub_category=new SubCategoryModel;
        $sub_category->category_id=$request->txtDanhMuc;
        $sub_category->sub_category_name=$request->txtDanhMucChiTiet;
        $sub_category->sub_category_status=$request->txtTrangThai;
        $sub_category->sub_category_desc=$request->desc;
        $sub_category->slug_sub_category=slug($request->txtDanhMucChiTiet);
        $sub_category->save();
        return redirect('admin/danh-muc-con/them-moi')->with('thongbao','Thêm thành công');
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
        $sub_category=SubCategoryModel::find($id);
        $category=CategoryModel::all();
        return view('admin.pages.sub_category.edit',['sub_category'=>$sub_category,'category'=>$category]);
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
            [
                'txtDanhMuc'=>'required',
                'txtDanhMucChiTiet'=>'required|min:3|max:100',
                'desc'=>'required',
            ],
            [
                'txtDanhMuc.required'=>'Bạn phải chọn danh mục',
                'txtDanhMucChiTiet.required'=>'Bạn phải điền vào tên danh mục chi tiết',
                'txtDanhMucChiTiet.min'=>'Tên danh mục chi tiết từ 3 đến 100 kí tự',
                'txtDanhMucChiTiet.max'=>'Tên danh mục chi tiết từ 3 đến 100 kí tự',
                'desc.required'=>'Bạn phải điền vào mô tả danh mục chi tiết',
            ]);
        $sub_category=SubCategoryModel::find($id);
        $sub_category->category_id=$request->txtDanhMuc;
        $sub_category->sub_category_name=$request->txtDanhMucChiTiet;
        $sub_category->sub_category_status=$request->txtTrangThai;
        $sub_category->sub_category_desc=$request->desc;
        $sub_category->slug_sub_category=slug($request->txtDanhMucChiTiet);
        $sub_category->save();
        return redirect('admin/danh-muc-con/them-moi')->with('thongbao','Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sub_category=SubCategoryModel::find($id);
        $thongbao="Xóa danh mục con ".$sub_category->sub_category_name." thành công";
        $sub_category->delete();
        $sub_category=SubCategoryModel::orderBy('sub_category_status', 'desc')->orderBy('category_id', 'asc')->get();
        return view('admin.pages.sub_category.display')->with(compact('sub_category','thongbao'));
    }
}
