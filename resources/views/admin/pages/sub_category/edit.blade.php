@extends('admin.layouts.index')

@section('content')
<div class="content-wrapper center">
            <!-- Main content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Danh mục chi tiết
                            <small></small>
                        </h1>
                    </div>
                    @if(session('thongbao'))
                                <div class="col-lg-12 alert alert-success">
                                    {{
                                        session('thongbao')
                                    }}
                                </div>
                    @endif
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-12" style="padding-bottom:120px">
                        <form action="admin/danh-muc-con/sua/{{$sub_category->id}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Danh mục</label>
                                <select class="form-control" name="txtDanhMuc">
                                    <option value="0" disabled >--Chọn danh mục--</option>
                                    @foreach($category as $c)
                                    <option value="{{$c->id}}"

                                    @if($c->id==$sub_category->category_id)
                                    {{"selected"}}
                                    @endif
                                     >{{$c->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('txtDanhMuc'))
                                <div class="alert alert-danger">
                                    {{
                                        $errors->first('txtDanhMuc')
                                    }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Tên danh mục chi tiết</label>
                                <input class="form-control" name="txtDanhMucChiTiet" placeholder="Điền vào tên danh mục chi tiết" value="{{$sub_category->sub_category_name}}" />
                            </div>
                            @if($errors->has('txtDanhMucChiTiet'))
                                <div class="alert alert-danger">
                                    {{
                                        $errors->first('txtDanhMucChiTiet')
                                    }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Mô tả danh mục chi tiết</label>
                                <input class="form-control" name="desc" value="{{$sub_category->sub_category_desc}}" />
                            </div>
                            @if($errors->has('desc'))
                                <div class="alert alert-danger">
                                    {{
                                        $errors->first('desc')
                                    }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Trạng thái</label>
                                
                                <label class="radio-inline">
                                    <input name="txtTrangThai" value="1"  type="radio" 
                                    @if($sub_category->sub_category_status==1)
                                    {{"checked"}}
                                    @endif
                                    >Hiển thị
                                </label>
                                <label class="radio-inline">
                                    <input name="txtTrangThai" value="0"  type="radio"
                                    @if($sub_category->sub_category_status==0)
                                    {{"checked"}}
                                    @endif
                                    >Ẩn
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Lưu</button>
                            
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection