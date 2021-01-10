<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\SubCategoryModel;
use App\Models\CommentModel;
use App\Models\ThumbnailModel;
use App\Models\SliderModel;
use App\Models\CustomerModel;
use App\Models\OrderDetailsModel;
use DB;
use Session;
class PageController extends Controller
{
	function __construct()
	{
		
		//$this->isLogin();
		$category=CategoryModel::where('category_status',1)->get();
		view()->share('category',$category);
	}
	public function isLogin()
	{
		if($request->session()->has('customer_id'))
        {
            view()->share('customer_id', Session::get('customer_id'));
            
        }
	}
	public function homePage()
	{
        $slider_active=SliderModel::where('status',2)->first();
        $slider=SliderModel::where('status',1)->get();
        // $category_active=CategoryModel::first();
        // $category_hp=CategoryModel::where('id','!=',$category_active->id)->get();
        $dt=CategoryModel::where('slug_category','dien-thoai')->first();
        $p_dt=ProductModel::where('category_id',$dt->id)->where('product_status',3)->take(3)->get();
        $tablet=CategoryModel::where('slug_category','tablet')->first();
        $p_tablet=ProductModel::where('category_id',$tablet->id)->where('product_status',3)->take(3)->get();
        $pk=CategoryModel::where('slug_category','phu-kien')->first();
        $p_pk=ProductModel::where('category_id',$pk->id)->where('product_status',3)->take(3)->get();
        //var_dump($p_dt->id);
        $recomend_product_active=$users = DB::select('select id,product_name,product_price,count(id),product_image from order_detail group by id,product_name,product_price,product_image
        order by  count(id) DESC limit 0,3 ');
        $recomend_product=$users = DB::select('select id,product_name,product_price,count(id),product_image from order_detail group by id,product_name,product_price,product_image
        order by  count(id) DESC limit 3,3 ');

		return view('frontend.pages.homepage')->with(compact('slider_active','slider','recomend_product','recomend_product_active','dt','p_dt','pk','p_pk','tablet','p_tablet'));

	}
    public function search(Request $request)
    {
        $search=$request->search;

        $product=ProductModel::where('product_name','like','%'.$search.'%')->where('product_status',3)->paginate(9);
        $slider_active=SliderModel::where('status',2)->first();
        $slider=SliderModel::where('status',1)->get();
        return view('frontend.pages.product',
            ['product'=>$product,
            'name_page'=>'Sản phẩm liên quan',
            'slider_active'=>$slider_active,
            'slider'=>$slider,
            ]);
    }

	public function display($slug_category)
    {
    	$category=CategoryModel::where('slug_category',$slug_category)->first();
    	$category_id=$category->id;
    	
    	$product=ProductModel::where('category_id',$category_id)->where('product_status',3)->paginate(9);
        $name_page=$category->category_name;
        $slider_active=SliderModel::where('status',2)->first();
        $slider=SliderModel::where('status',1)->get();
    	//var_dump($product);
    	return view('frontend.pages.product')->with(compact('product','name_page','slider_active','slider','category_id'));
    }
    public function displayDetails($slug_category,$slug_sub_category)
    {
    	
    	$sub_category=SubCategoryModel::where('slug_sub_category',$slug_sub_category)->first();
    	
    	$sub_category_id=$sub_category->id;
    	$name_page=$sub_category->sub_category_name;
    	$product=ProductModel::where('sub_category_id',$sub_category_id)->where('product_status',3)->paginate(9);
        $slider_active=SliderModel::where('status',2)->first();
        $slider=SliderModel::where('status',1)->get();
    	//var_dump($product);
    	return view('frontend.pages.product')->with(compact('product','name_page','slider_active','slider','sub_category_id'));
    }
    public function productDetails($slug_product)
    {
    	$product=ProductModel::where('slug_product',$slug_product)->first();
        $product->product_view=$product->product_view+1;
        $product->save();
    	$id;$related_product;$related_product_active;
        $comment=CommentModel::where('product_id',$product->id)->orderBy('updated_at','ASC')->paginate(5);
        //$time=$comment->updated_at;
        //$time_cm=TimeSince($time);
        $thumbnail=ThumbnailModel::where('product_id',$product->id)->take(3)->get();
        if(!$thumbnail)
        {
            $thumbnail="";
        }
    	if($product->sub_category_id!=0)
    	{
    		$id=$product->sub_category_id;
    		$related_product_active=ProductModel::where('sub_category_id',$id)->where('brand_id',$product->brand_id)->first();
    		$related_product=ProductModel::where('sub_category_id',$id)->where('brand_id',$product->brand_id)->take(3)->get();
    		
    	}
    	else
    	{
    		$id=$product->category_id;
    		$related_product=ProductModel::where('category_id',$id)->where('brand_id',$product->brand_id)->take(3)->get();
    		$related_product_active=ProductModel::where('category_id',$id)->where('brand_id',$product->brand_id)->first();
    	}
    	
    	    	
    	return view('frontend.pages.detail_product',
    		[
    		'product'=>$product,
    		'related_product'=>$related_product,
    		'related_product_active'=>$related_product_active,
            'comment'=>$comment,
            'thumbnail'=>$thumbnail,
    		]);
    }


    public function comment(Request $request)
    {
        // $comment=new CommentModel;
        // $comment->user_id=Session::get('customer_id');
        // $comment->product_id=$request->product_id;
        // $comment->comment=$request->comment; date_default_timezone_set('Asia/Ho_Chi_Minh');
        //  $comment->created_at = now();
        //  $comment->updated_at = now();
        // $comment->save();
        // return redirect()->back();

        //ajax
        $comment=new CommentModel;
        $comment->user_id=Session::get('customer_id');
        $comment->product_id=$request->id_product;
        $comment->comment=$request->comment;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $comment->created_at = now();
        $comment->updated_at = now();
        $comment->save();


    }
    public function allComment(Request $request)
    {
        $comment=CommentModel::where('product_id',$request->id)->orderBy('updated_at','DESC')->paginate(5);
        $customer=CustomerModel::find(Session::get('customer_id'));
        foreach ($comment as $cm) {
            $img="";
            $action="";

            //check anh dai dien
            if($cm->customer->customer_avatar!="")
            {
                $img='<img class="img-circle img-sm" src="img/avatar/'.$cm->customer->customer_avatar.'" width="30px" height="30px" alt=""/>';
            }
            else
            {
                $img='<img class="img-circle img-sm" src="img/avatar/user.jpg" width="30px" height="30px" alt=""/>';
            }   

            //check quyen sua xoa
            if($cm->user_id==$customer->id)
            {
                $action='<span><a class="btn btn-infor">Sửa</a></span><span><a class="btn btn-infor delete-comment" data-id="'.$cm->id.'"">Xóa</a></span>';
            }
            echo '<div class="media">

                                    <a class="pull-left" href="#">'.$img.'
                                        
                                        
                                        
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading" style="color:red">'.$cm->customer->customer_name.'
                                            <small><i class="fas fa-clock">'.$cm->created_at.'</i></small>
                                        
                                        </h4>
                                        <p>'.$cm->comment.'</p>
                                        '.$action.'
                                    </div>
                                </div>';
        }
    }

    public function chat()
    {
        return view('frontend.pages.chat');
    }


    // public function TimeSince($original) // $original should be the original date and time in Unix format
    // {
    //     // Common time periods as an array of arrays
    //     $periods = array(
    //         array(60 * 60 * 24 * 365 , 'year'),
    //         array(60 * 60 * 24 * 30 , 'month'),
    //         array(60 * 60 * 24 * 7, 'week'),
    //         array(60 * 60 * 24 , 'day'),
    //         array(60 * 60 , 'hour'),
    //         array(60 , 'minute'),
    //         );

    //     $today = time();
    //     $since = $today - $original; // Find the difference of time between now and the past

    //     // Loop around the periods, starting with the biggest
    //     for ($i = 0, $j = count($periods); $i < $j; $i++)
    //     {
    //         $seconds = $periods[$i][0];
    //         $name = $periods[$i][1];

    //         // Find the biggest whole period
    //         if (($count = floor($since / $seconds)) != 0)
    //         {
    //             break;
    //         }
    //     }

    //     $output = ($count == 1) ? '1 '.$name : "$count {$name}s";

    //     if ($i + 1 < $j)
    //     {
    //         // Retrieving the second relevant period
    //         $seconds2 = $periods[$i + 1][0];
    //         $name2 = $periods[$i + 1][1];

    //         // Only show it if it's greater than 0
    //         if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0)
    //         {
    //             $output .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
    //         }
    //     }
    //     return $output;
    // }

    // public function sort($category,$val)
    // {
    //     $category=CategoryModel::where('slug_category',$category)->first();
    //     $id=$category->id;
    //     $product="";
    //     if($val==1)
    //     {
    //          $product=ProductModel::where('category_id',$id)->where('product_status',3)->where('product_price','ASC')->paginate(9);
    //     }
    //     else if($val==2)
    //     {
    //         $product=ProductModel::where('category_id',$id)->where('product_status',3)->where('product_price','DESC')->paginate(9);
    //     }
    //     $name_page=$category->category_name;
    //     $slider_active=SliderModel::where('status',2)->first();
    //     $slider=SliderModel::where('status',1)->get();
    //     //var_dump($product);
    //     return view('frontend.pages.product')->with(compact('product','name_page','slider_active','slider'));
    //     //echo $val;
    // }
    // public function sort_sub($category,$sub_category,$val)
    // {
    //     echo $val;
    // }
    public function sort(Request $request)
    {
        if(isset($request->category_id))
        {
            $id=$request->category_id;
            $category=CategoryModel::where('id',$id)->first();
            $category_id=$category->id;
            $product="";
            $val=$request->sort;
                if($val==1)
                {
                     $product=ProductModel::where('category_id',$id)->where('product_status',3)->orderBy('product_price','ASC')->paginate(100);
                     
                }
                else if($val==0)
                {
                    $product=ProductModel::where('category_id',$id)->where('product_status',3)->orderBy('created_at','DESC')->paginate(100);
                }
                else if($val==2)
                {
                    $product=ProductModel::where('category_id',$id)->where('product_status',3)->orderBy('product_price','DESC')->paginate(100);
                }
            $name_page=$category->category_name;
            $slider_active=SliderModel::where('status',2)->first();
            $slider=SliderModel::where('status',1)->get();
            //var_dump($val);
             return view('frontend.pages.product')->with(compact('product','name_page','slider_active','slider','category_id'));
        }
        elseif (isset($request->sub_category_id)) {
            $id=$request->sub_category_id;
            $sub_category=SubCategoryModel::where('id',$id)->first();
            $sub_category_id=$sub_category->id;
            $product="";
            $val=$request->sort;
                if($val==1)
                {
                     $product=ProductModel::where('sub_category_id',$id)->where('product_status',3)->orderBy('product_price','ASC')->paginate(100);
                     
                }
                else if($val==0)
                {
                    $product=ProductModel::where('sub_category_id',$id)->where('product_status',3)->orderBy('created_at','ASC')->paginate(100);
                }
                else if($val==2)
                {
                    $product=ProductModel::where('sub_category_id',$id)->where('product_status',3)->orderBy('product_price','DESC')->paginate(100);
                }
            $name_page=$sub_category->sub_category_name;
            $slider_active=SliderModel::where('status',2)->first();
            $slider=SliderModel::where('status',1)->get();
            //var_dump($val);
             return view('frontend.pages.product')->with(compact('product','name_page','slider_active','slider','sub_category_id'));
        }
    }
    
}



