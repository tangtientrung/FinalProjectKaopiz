@extends('frontend.layouts.index')
@section('css')
<link href="frontend/css/sweetalert.css" rel="stylesheet">
@endsection
@section('content')
<section>
		<div class="container">
			<div class="row">
				
				
				<div class="col-sm-12">
					
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="img/product/{{$product->product_image}}" alt="" />
								
							</div>
							@if(count($thumbnail)>2)
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="item active">

										  <img width="80px" src="img/thumbnail/{{$product->product_image}}" alt="">
										  @foreach($thumbnail as $t)
										  <img width="80px" src="img/thumbnail/{{$t->link}}" alt="">
										  @endforeach
										</div>
										<div class="item">
										  @foreach($thumbnail as $t)
										  <a href=""><img width="100px" src="img/thumbnail/{{$t->link}}" alt=""></a>
										  @endforeach
										</div>
										
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>
							@endif
						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{$product->product_name}}</h2>
								<p>Mã sản phẩm: {{$product->id}}</p>
								<img src="images/product-details/rating.png" alt="" />
								<span>
									<form>
										@csrf
										<!-- <input type="hidden" name="id_product" value="{{$product->id}}">
										<span>{{number_format($product->product_price).' VNĐ'}}</span>
										<label>Số lượng:</label>
										
										<input name="quantity" type="number" min="1"  value="1" />
										<button type="submit" class="btn btn-fefault cart">
											<i class="fa fa-shopping-cart"></i>
											Thêm giỏ hàng
										</button> -->
										<input type="hidden" value="{{$product->id}}" class="product_id">
					                    <input type="hidden" value="{{$product->product_name}}" class="product_name">
					                    <input type="hidden" value="{{$product->product_image}}" class="product_image">
					                    @if(isKM($product->bdkm,$product->ktkm))
					                      <input type="hidden" value="{{$product->product_price_km}}" class="product_price">
					                      @else
					                      <input type="hidden" value="{{$product->product_price}}" class="product_price">
					                      @endif
					                    
					                    @if(isKM($product->bdkm,$product->ktkm))
					                     
					                      <strike style="color:red">{{number_format($product->product_price).' VNĐ'}}</strike>
					                      <br/>
					                      <span>{{number_format($product->product_price_km).' VNĐ'}}</span>
					                      @else
					                      <span>{{number_format($product->product_price).' VNĐ'}}</span>
					                    @endif
					                    
					                    <label>Số lượng:</label>
										
										<input name="quantity" class="product_qty" type="number" min="1"  value="1" />

					                      

					                                             
					                    @if($product->product_qty>0)
					                    <button type="button" class="btn btn-default cart add-to-cart" name="add-to-cart"><i class="fa fa-shopping-cart"></i>
											Thêm giỏ hàng</button>
										@endif
									</form>
									
								</span>
								<p><b>Tình trạng:</b>
									@if($product->product_qty==0)
									{{"Hết hàng"}}
									@else
									{{"Còn hàng"}}
									@endif
								 </p>
								<p><b>Trạng thái:</b> Mới</p>
								<p><b>Thương hiệu:</b> {{$product->brand->brand_name}}</p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
								<div class="" id="details" >
								<h3>Thông số kĩ thuật</h3>
								{!!$product->product_desc!!}
								
							</div>
							
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								
								<li class="active"><a href="#comment" data-toggle="tab">Comment</a></li>
								<li ><a href="#review" data-toggle="tab">Review sản phẩm</a></li>
								
								
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="comment" >
								
        
								@if(session('customer_id'))
								<div class="row bootstrap snippets bootdeys">
								    <div class="col-sm-12">
								        <div class="comment-wrapper">
								            <div class="panel panel-info">
								                
								                <div class="panel-body">

								                	<!-- loadcomment thuong -->
								                	<!-- <form action="/binh-luan" method="post">
								                	@csrf
								                    <textarea class="form-control comment" placeholder="bình luận..." name="comment" rows="3"></textarea>
								                    <br>
								                    <input type="hidden" value="{{$product->id}}" name="product_id"/>
								                    <input type="submit" name="" class="btn btn-info pull-right"
								                    value="Đăng"/>
								                    </form> -->

								                    <!--ajax -->
								                    <form>
								                	@csrf
								                    <textarea class="form-control comment" name="comment" placeholder="bình luận..." rows="3"></textarea>
								                    <br>
								                   <input type="hidden" value="{{$product->id}}" name="id_product" class="id_product"/>
								                   <button type="button" class="btn btn-info pull-right post-comment">Đăng</button>
								                    </form> 
								                </div>
								            </div>
								        </div>
								    </div>

    							</div>
    							@endif
    							<div id="loadComment"></div>

    							<!-- loadcomment thuong -->
    							<!-- @foreach($comment as $cm)
    							<div class="media">

				                    <a class="pull-left" href="#">
				                    	@if($cm->customer->customer_avatar!="")
				                    	<img class="img-circle img-sm" src="img/avatar/{{$cm->customer->customer_avatar}}" width="30px" height="30px" alt=""/>
				                    	@else
				                        <img class="img-circle img-sm" src="img/avatar/user.jpg" width="30px" height="30px" alt=""/>
				                        @endif
				                    </a>
				                    <div class="media-body">
				                        <h4 class="media-heading">{{$cm->customer->customer_name}}
				                            <small><i class="fas fa-clock">{{$cm->created_at}}</i></small>
				                        
				                        </h4>
				                        {{$cm->comment}}
				                    </div>
				                </div>
				                @endforeach -->







    							
                				<div class="col-sm-12">
           						<div class="col-sm-5"></div>
           						<div class="col-sm-3">
	           					 @if ($comment->lastPage() > 1)
									<ul class="pagination">
									    <li class="{{ ($comment->currentPage() == 1) ? ' disabled' : '' }}">
									        <a href="{{ $comment->url(1) }}">Trước</a>
									    </li>
									    @for ($i = 1; $i <= $comment->lastPage(); $i++)
									        <li class="{{ ($comment->currentPage() == $i) ? ' active' : '' }}">
									            <a href="{{ $comment->url($i) }}">{{ $i }}</a>
									        </li>
									    @endfor
									    <li class="{{ ($comment->currentPage() == $comment->lastPage()) ? ' disabled' : '' }}">
									        <a href="{{ $comment->url($comment->currentPage()+1) }}" >Sau</a>
									    </li>
									</ul>
								@endif
								</div>
							</div>
           					 </div>
           					
           					
						
							
							<div class="tab-pane fade" id="review" >
								{!!$product->product_content!!}
							</div>
							
							
						</div>
					</div>
							
							
							
							
						
					
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">	
									@foreach($related_product as $rp)
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<a href="san-pham/chi-tiet/{{$rp->slug_product}}">
													<img src="img/product/{{$rp->product_image}}" alt="" />
													<h2>{{number_format($rp->product_price).' VNĐ'}}</h2>
													<p>{{$rp->product_name}}</p>
													</a>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>
								<div class="item">	
									@foreach($related_product as $rp)
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<a href="san-pham/chi-tiet/{{$rp->slug_product}}">
													<img src="img/product/{{$rp->product_image}}" alt="" />
													<h2>{{number_format($rp->product_price).' VNĐ'}}</h2>
													<p>{{$rp->product_name}}</p>
													</a>
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
        	loadComment();
            $('.add-to-cart').click(function(){
              var id = $('.product_id').val();
              var product_name = $('.product_name').val();
              var product_image = $('.product_image' ).val();
              var product_price = $('.product_price').val();
              var product_qty = $('.product_qty' ).val();
              var token = $('input[name="_token"]').val();
              //swal("Hello world!");
              //alert(token);

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
                     // swal("", "Đã thêm sản phẩm vào giỏ hàng!", "success");
                        swal({
                                title: "Đã thêm sản phẩm vào giỏ hàng",
                                
                                showCancelButton: true,
                                cancelButtonText: "Xem tiếp",
                                cancelButtonClass: "btn-danger",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Đi đến giỏ hàng",
                                closeOnConfirm: false
                            },
                            function() {
                                window.location.href = "{{url('/gio-hang')}}";
                            });

                    }

                });

            });

            //ajax
            $('.post-comment').click(function(){
            	var comment = $('.comment').val();
            	var id_product = $('.id_product').val();
            	
            	var token = $('input[name="_token"]').val();
            	//alert(id_product);
            	if(comment=="")
            	{
            		//alert('Không được bỏ trống');
            		swal("Không được bỏ trống", "", "error");
            	}
            	else
            	{
            		$.ajax({
                     method:'POST',
                     url:'/binh-luan',
                    data:{comment:comment,
                          id_product:id_product,
                          _token:token},
                          success:function(data){
                          	
                          	// location.reload();
                          	loadComment();
                          }
                    });
            	}
            	
            });
            //ajax
            $('.delete-comment').click(function(){
            	// var comment = $('.comment').val();
            	// var id_product = $('.id_product').val();
            	
            	// var token = $('input[name="_token"]').val();
            	// //alert(id_product);
            	// $.ajax({
             //         method:'POST',
             //         url:'/binh-luan',
             //        data:{comment:comment,
             //              id_product:id_product,
             //              _token:token},
             //              success:function(data){
                          	
             //              	// location.reload();
             //              	loadComment();
             //              }
             //        });
             alert('ss');
            });



            function loadComment(){
            	var token = $('input[name="_token"]').val();
            	var id_product = $('.id_product').val();
            	$.ajax({
                     method:'POST',
                     url:'/tat-ca-binh-luan',
                    data:{
                    	 id:id_product,
                    	_token:token},
                          success:function(data){
                          	$('#loadComment').html(data);
                          }
                    });
            }
        });
    </script>

  @endsection