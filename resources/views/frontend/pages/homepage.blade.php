@extends('frontend.layouts.index')
@section('css')
<link href="frontend/css/sweetalert.css" rel="stylesheet">
@endsection
@section('content')
<section id="slider"><!--slider-->
    <div class="container">
      <div class="row">
        <?php ?>

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
          
          <div class="features_items"><!--features_items-->
            <div>
              <div class="col-sm-11">
                <br/>
                <h2 class="title text-center">{{$dt->category_name}}</h2>
              </div>
             <div class="col-sm-1">
                <a class="title text-right" href="danh-muc/{{$dt->slug_category}}">Xem thêm</a>
              </div>
            </div>
            
            @foreach($p_dt as $p)
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
                      </p>
                      <h2>{{number_format($p->product_price).' VNĐ'}}</h2>
                      @endif
                      <p>{{$p->product_name}}</p>
                      </a>
                      <form >
                      @csrf
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
                    <!-- <div class="product-overlay">
                      <div class="overlay-content">
                        <h2>$56</h2>
                        <p>Easy Polo Black Edition</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                      </div>
                    </div> -->
                </div>
                <div class="choose">
                  <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                  </ul>
                </div>
              </div>
            </div>
            @endforeach
            
          </div><!--features_items-->
          <div class="features_items"><!--features_items-->
            <div>
              <div class="col-sm-11">
                <h2 class="title text-center">{{$tablet->category_name}}</h2>
              </div>
             <div class="col-sm-1">
                <a class="title text-right" href="danh-muc/{{$tablet->slug_category}}">Xem thêm</a>
              </div>
            </div>
            
            @foreach($p_tablet as $p)
            <div class="col-sm-4">
              <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                      <a href="san-pham/chi-tiet/{{$p->slug_product}}">
                      <img src="img/product/{{$p->product_image}}" alt="" />
                      @if(isKM($p->bdkm,$p->ktkm))
                      <br/>
                      <strike style="color:red">{{number_format($p->product_price).' VNĐ'}}</strike>
                      <h2>{{number_format($p->product_price_km).' VNĐ'}}</h2>
                      @else
                      <h2>{{number_format($p->product_price).' VNĐ'}}</h2>
                      @endif
                      <p>{{$p->product_name}}</p>
                      </a>
                       <form >
                      @csrf
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
            @endforeach
            
          </div><!--features_items-->
          <div class="features_items"><!--features_items-->
            <div>
              <div class="col-sm-11">
                <h2 class="title text-center">{{$pk->category_name}}</h2>
              </div>
             <div class="col-sm-1">
                <a class="title text-right" href="danh-muc/{{$pk->slug_category}}">Xem thêm</a>
              </div>
            </div>
            
            @foreach($p_pk as $p)
            <div class="col-sm-4">
              <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                      <a href="san-pham/chi-tiet/{{$p->slug_product}}">
                      <img src="img/product/{{$p->product_image}}" alt="" />
                      @if(isKM($p->bdkm,$p->ktkm))
                      <br/>
                      <strike style="color:red">{{number_format($p->product_price).' VNĐ'}}</strike>
                      <h2>{{number_format($p->product_price_km).' VNĐ'}}</h2>
                      @else
                      <h2>{{number_format($p->product_price).' VNĐ'}}</h2>
                      @endif
                      <p>{{$p->product_name}}</p>
                      </a>
                       <form >
                      @csrf
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
            @endforeach
            
          </div><!--features_items-->
          
          <br/>
          <div class="recommended_items"><!--recommended_items-->
            <br/>
            <h2 class="title text-center">Sản phẩm hot</h2>
            
            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="item active"> 
                  @foreach($recomend_product_active as $r) 
                  <div class="col-sm-4">
                    <div class="product-image-wrapper">
                      <div class="single-products">
                        <div class="productinfo text-center">
                          
                          <img src="img/product/{{$r->product_image}}" alt="" />
                         
                          <h2>{{number_format($r->product_price).' VNĐ'}}</h2>
                         
                          <p>{{$r->product_name}}</p>
                          
                          
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  @endforeach
                  
                </div>
                <div class="item"> 
                @foreach($recomend_product as $r)   
                  <div class="col-sm-4">
                    <div class="product-image-wrapper">
                      <div class="single-products">
                        <div class="productinfo text-center">
                          
                          <img src="img/product/{{$r->product_image}}" alt="" />
                          
                          <h2>{{number_format($r->product_price).' VNĐ'}}</h2>
                        
                          <p>{{$r->product_name}}</p>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                @endforeach
                </div>
              </div>
          
               <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
                </a>      
            </div>
          </div><!--/recommended_items-->
          
        </div>
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
                      swal("Đã thêm sản phẩm vào giỏ hàng!","", "success");
                      

                    }

                });

            });

            
        });
    </script>

  @endsection