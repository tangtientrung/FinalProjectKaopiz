@extends('frontend.layouts.index')
@section('css')
<link href="frontend/css/sweetalert.css" rel="stylesheet">
@endsection
@section('content')
<section id="slider"><!--slider-->
    <div class="container">
      <div class="row">
        
        <!-- <div class="col-sm-12">
          <span>Chọn mức giá</span>
          
            <input type="text" name="" id="price"/>
            

        </div> -->
        <div class="col-sm-12">
          <div id="slider-carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
              <li data-target="#slider-carousel" data-slide-to="1"></li>
              <li data-target="#slider-carousel" data-slide-to="2"></li>
            </ol>
            
            <div class="carousel-inner">
              <div class="item active">
                <div class="col-sm-6">
                  <h1><span>E</span>-SHOP</h1>
                  <h2>Shop điện tử số 1 Việt Nam</h2>
                  <p>Địa chỉ:Nhổn-Nam Từ Liêm-Hà Nội </p>
                  <p>SĐT:0123456789</p>
                  <a type="button" href="#" class="btn btn-default get">Mua sắm ngay</a>
                </div>
                <div class="col-sm-6">
                  <img width="484px" height="441px" src="img/slider/{{$slider_active->image}}" class="girl img-responsive" alt="" />
                  <!-- <img src="frontend/images/home/pricing.png"  class="pricing" alt="" /> -->
                </div>
              </div>
              @foreach($slider as $s)
              <div class="item">
                <div class="col-sm-12">
                  <img src="img/slider/{{$s->image}}" width="950px" height="441px" class="girl img-responsive" alt="" />
                  </div>
              </div>
              @endforeach
              
              
            </div>
            
            <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
              <i class="fa fa-angle-left"></i>
            </a>
            <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
          
        </div>
      </div>
    </div>
</section><!--/slider-->
  
  <section>
    <div class="container">
      <div class="row">
        
        <div class="col-sm-12">
         
            @if(isset($category_id)||isset($sub_category_id))
            <form method="post" action="san-pham/sort">
              @csrf
              <div class="col-sm-9"></div>
              <div class="col-sm-2">
              @if(isset($category_id))
              <input type="hidden" name="category_id" value="{{$category_id}}" />
              @endif
              @if(isset($sub_category_id))
              <input type="hidden" name="sub_category_id" value="{{$sub_category_id}}" />
              @endif
              <select name="sort" class="text-right" id="sort" value="{{ old('sort') }}">
              <option value="0" selected="">Mới nhất</option>
              <option value="1">Giá từ thấp đến cao</option>
              <option value="2">Giá từ cao đến thấp</option>
              <!-- <option value="3">Nổi bật nhất</option> -->
              option
              </select>
              </div>
              <div class="col-sm-1">
              <input type="submit" name="" value="Lọc">
              </div>
            </form>
            @endif
        </div>
        <div class="col-sm-12">
          

          <div class="features_items"><!--features_items-->
            <br/>
            <h2 class="title text-center">{{$name_page}} nổi bật</h2>
            
            @foreach($product as $p)
            <div class="col-sm-4">
              <div class="product-image-wrapper">
                <div class="single-products">

                    <div class="productinfo text-center">
                      <a href="san-pham/chi-tiet/{{$p->slug_product}}">
                     
                      
                      <img src="img/product/{{$p->product_image}}" alt="" />
                      <p>
                      @if(isKM($p->bdkm,$p->ktkm))
                      <br/>
                      <strike style="color:red">{{number_format($p->product_price).' VNĐ'}}</strike>
                      <h2>{{number_format($p->product_price_km).' VNĐ'}}</h2>
                      @else
                      <h2>{{number_format($p->product_price).' VNĐ'}}</h2>
                      @endif
                      </p>
                      <p>{{$p->product_name}}</p>
                      </a>
                      <form >
                      @csrf
                      <!-- <input type="hidden" name="id_product" value="{{$p->id}}">
                      <input type="hidden" name="quantity" type="text" value="1" />
                      <button type="submit" class="btn btn-fefault cart">
                        <i class="fa fa-shopping-cart"></i>
                        Thêm giỏ hàng
                    </button> -->
                      <input type="hidden" value="{{$p->id}}" class="cart_product_id_{{$p->id}}">
                      <input type="hidden" value="{{$p->product_name}}" class="cart_product_name_{{$p->id}}">
                      <input type="hidden" value="{{$p->product_image}}" class="cart_product_image_{{$p->id}}">
                      @if(isKM($p->bdkm,$p->ktkm))
                      <input type="hidden" value="{{$p->product_price_km}}" class="cart_product_price_{{$p->id}}">
                      @else
                      <input type="hidden" value="{{$p->product_price}}" class="cart_product_price_{{$p->id}}">
                      @endif
                      
                      <input type="hidden" value="1" class="cart_product_qty_{{$p->id}}">

                      

                                             
                      
                    <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$p->id}}" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>

                  </form>
                    </div>
                </div>
                <div class="choose">
                  <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                  </ul>
                </div>
              </div>
            </div>
        	</a>
            @endforeach

            </div>
            </br>
            <div class="col-sm-5"></div>
            <div class="col-sm-7 padding-right" >{{ $product->links() }}</div>
          </div><!--features_items-->
          
          
      </div>
    </div>
  </section>

  @endsection
  @section('script')
  <script src="frontend/js/sweetalert.js"></script>
  <script type="text/javascript">
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
              var id = $(this).data('id_product');
              var product_name = $('.cart_product_name_' + id).val();
              var product_image = $('.cart_product_image_' + id).val();
              var product_price = $('.cart_product_price_' + id).val();
              var product_qty = $('.cart_product_qty_' + id).val();
              var token = $('input[name="_token"]').val();
              //swal("Hello world!");
              //alert(product_name);

              $.ajax({
                     method:'POST',
                     url:'/them-gio-hang',
                    data:{product_id:id,
                          product_name:product_name,
                          product_image:product_image,
                          product_price:product_price,
                          product_qty:product_qty,
                          _token:token},
                    success:function(){
                      //alert(data);
                      swal("", "Đã thêm sản phẩm vào giỏ hàng!", "success");
                      
                        // swal({
                        //         title: "Đã thêm sản phẩm vào giỏ hàng",
                                
                        //         showCancelButton: true,
                        //         cancelButtonText: "Xem tiếp",
                        //         cancelButtonClass: "btn-danger",
                        //         confirmButtonClass: "btn-success",
                        //         confirmButtonText: "Đi đến giỏ hàng",
                        //         closeOnConfirm: false
                        //     },
                        //     function() {
                        //         window.location.href = "{{url('/gio-hang')}}";
                        //     });

                    }

                });

            });
            $('#price').keyup(function(){
                var price=$(this).val();
                $.get("ajax/keyup/"+price,function(data){
                    $("#price").val(data);
                    // //alert(data);
                    // location.reload();
                    //alert(data);
                });
            });
            $('#sort').change(function(){
              var pathname = window.location.pathname;
              var i=0;
              var j=pathname.indexOf("/");
              pathname=pathname.slice(j+1,pathname.length);
              var j=pathname.indexOf("/");
              pathname=pathname.slice(j+1,pathname.length);
              var val=$(this).val();
              if(pathname.indexOf('/')>0)
              {
                $.get("san-pham/"+pathname+"/"+val,function(data){
                alert(data);
              });

              }
              else
              {
                $.get("san-pham/"+pathname+"/"+val,function(data){
                alert(data);
              });
              }
              // for(i;i<pathname.length;i++)
              // {

              // }
              
              //alert(pathname);
            });
        });
    </script>

  @endsection