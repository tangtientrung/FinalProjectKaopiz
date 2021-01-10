@extends('admin.layouts.index')

@section('content')
<div class="content-wrapper center">
            <!-- Main content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Danh mục chi tiết
                            <small>Thêm</small>
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
                        <form action="admin/danh-muc-con/them-moi" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Danh mục</label>
                                <select class="form-control" name="txtDanhMuc" value="{{ old('txtDanhMuc') }}">
                                    <option value="0" disabled selected>--Chọn danh mục--</option>
                                    @foreach($category as $c)
                                    <option value="{{$c->id}}" >{{$c->category_name}}</option>
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
                                <input class="form-control" name="txtDanhMucChiTiet" placeholder="Điền vào tên danh mục chi tiết" value="{{ old('txtDanhMucChiTiet') }}"/>
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
                                <input class="form-control" name="desc" placeholder="Điền vào mô tả danh mục chi tiết" value="{{ old('desc') }}"/>
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
                                    <input name="txtTrangThai" value="1"  type="radio" checked="">Hiển thị
                                </label>
                                <label class="radio-inline">
                                    <input name="txtTrangThai" value="0"  type="radio">Ẩn
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Thêm</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection