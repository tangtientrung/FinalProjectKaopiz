<?php

use Illuminate\Support\Facades\Route;
// use Carbon\Carbon;
// use App\Models\ProductModel;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//use Session;
Route::get('/delete', function() {
    Session::flush();
});
Route::get('/', 'App\Http\Controllers\PageController@homePage');
Route::get('/chat', 'App\Http\Controllers\PageController@chat');
Route::get('dang-nhap','App\Http\Controllers\LoginController@getLogin')->middleware('checkLogin');
Route::post('dang-nhap','App\Http\Controllers\LoginController@postLogin' );
Route::get('/dang-ki','App\Http\Controllers\LoginController@getSignIn')->middleware('checkLogin');
Route::post('/dang-ki','App\Http\Controllers\LoginController@postSignIn' );
Route::get('logout','App\Http\Controllers\LoginController@logout');
Route::get('dang-xuat','App\Http\Controllers\UserController@logout');
Route::get('/verify/{id}','App\Http\Controllers\LoginController@verify')->name('verify')->middleware('signed');
Route::get('/verification.notice','App\Http\Controllers\LoginController@error')->name('verification.notice');
Route::get('quen-mat-khau','App\Http\Controllers\LoginController@forgotPW');
Route::post('quen-mat-khau','App\Http\Controllers\LoginController@postForgotPW' );
Route::post('nhap-email','App\Http\Controllers\LoginController@inputEmail' );
Route::get('xac-nhan-quen-mat-khau/{id}','App\Http\Controllers\LoginController@verifyPW')->name('verifyPW');

Route::get('admin/login-google','App\Http\Controllers\LoginController@login_google');
Route::get('admin/google/callback','App\Http\Controllers\LoginController@callback_google');
Route::get('tai-khoan','App\Http\Controllers\UserController@account');
Route::get('/danh-muc/{slug_category?}','App\Http\Controllers\PageController@display');
Route::get('/danh-muc/{slug_category}/{slug_category_details}','App\Http\Controllers\PageController@displayDetails');
Route::get('/san-pham/chi-tiet/{slug_product}','App\Http\Controllers\PageController@productDetails');
Route::get('/tim-kiem','App\Http\Controllers\PageController@search');

//gio gio-hang
Route::get('/gio-hang','App\Http\Controllers\CartUserController@show_cart');
Route::post('/them-gio-hang','App\Http\Controllers\CartUserController@add_to_cart');
Route::post('/gio-hang/cap-nhat','App\Http\Controllers\CartUserController@update_quantity');
Route::post('/gio-hang/xoa','App\Http\Controllers\CartUserController@delete');


//Route::get('/thanh-toan','App\Http\Controllers\UserCheckOutController@checkout');
// Route::get('/thanh-toan/dang-nhap','App\Http\Controllers\UserCheckOutController@getLogin');
// Route::post('/thanh-toan/dang-nhap','App\Http\Controllers\UserCheckOutController@postLogin' );
// Route::get('/thanh-toan/dang-ki','App\Http\Controllers\UserCheckOutController@getSignIn');
// Route::post('/thanh-toan/dang-ki','App\Http\Controllers\UserCheckOutController@postSignIn' );
Route::get('/session_checkout','App\Http\Controllers\AjaxController@session_checkout');

//Route::get('/session_checkout','App\Http\Controllers\AjaxController@session_checkout');

Route::post('/xac-nhan-dia-chi','App\Http\Controllers\UserCheckOutController@confirm_shipping' );
Route::post('/dat-mua','App\Http\Controllers\UserCheckOutController@buying' );

Route::get('/ajax/quan-huyen/{id}','App\Http\Controllers\AjaxController@quan_huyen');
Route::get('/ajax/xa-phuong/{id}','App\Http\Controllers\AjaxController@xa_phuong');
Route::get('/ajax/{matp}/{maqh}/{xaid}','App\Http\Controllers\AjaxController@money');
Route::get('/ajax/qty/up/{rowId}/{id}/{qty}','App\Http\Controllers\AjaxController@qty_up');
Route::get('/ajax/qty/down/{rowId}/{id}/{qty}','App\Http\Controllers\AjaxController@qty_down');
Route::get('/ajax/sub_category/{id}','App\Http\Controllers\AjaxController@subCategory');
Route::get('/ajax/keyup/{price}','App\Http\Controllers\AjaxController@keyup');
Route::get('/ajax/discount/{id}','App\Http\Controllers\AjaxController@subCategoryDiscount');


Route::get('/don-hang','App\Http\Controllers\UserCheckOutController@view_order');

// Route::get('/test', 'App\Http\Controllers\AjaxController@test');
Route::get('test1', function() {
    return view('frontend.login');
});
Route::get('/ajax','App\Http\Controllers\AjaxController@ajax');

// coupon
Route::post('/ma-giam-gia','App\Http\Controllers\CouponController@check' );
Route::get('/ma-giam-gia/{id}','App\Http\Controllers\CouponController@Cancel' );


//comment
Route::post('/binh-luan','App\Http\Controllers\PageController@comment' );
Route::post('/tat-ca-binh-luan','App\Http\Controllers\PageController@allComment' );

//sort
// Route::get('/san-pham/{category}/{val}','App\Http\Controllers\PageController@sort' );
// Route::get('/san-pham/{category}/{sub_category}/{val}','App\Http\Controllers\PageController@sort_sub' );
Route::post('/san-pham/sort','App\Http\Controllers\PageController@sort' );

//account

Route::post('cap-nhat-thong-tin/{id}', 'App\Http\Controllers\UserController@postEditProfile');
Route::get('doi-mat-khau', 'App\Http\Controllers\UserController@changePW')->middleware('checkChangePW');
Route::post('doi-mat-khau', 'App\Http\Controllers\UserController@postChangePW');
// Route::get('kiem-tra', 'App\Http\Controllers\UserController@checkCustomer');
// Route::post('kiem-tra', 'App\Http\Controllers\UserController@postCheckCustomer');

Route::group(['middleware'=>'checkChangePW'], function() {
    //account
    Route::get('cap-nhat-thong-tin', 'App\Http\Controllers\UserController@editProfile');
    Route::get('doi-mat-khau', 'App\Http\Controllers\UserController@changePW');
});
Route::group(['middleware'=>'checkLoginPayment'], function() {
    Route::get('/thanh-toan','App\Http\Controllers\UserCheckOutController@checkout');
});
//admin
Route::group(['prefix' => 'admin','middleware'=>'adminLogin'], function() {
    Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard');
    Route::get('/', 'App\Http\Controllers\AdminController@dashboard');

    //category admin
    Route::get('/danh-muc/hien-thi', 'App\Http\Controllers\CategoryController@index');
    Route::get('/danh-muc/them', 'App\Http\Controllers\CategoryController@create');
    Route::post('/danh-muc/them', 'App\Http\Controllers\CategoryController@store');
    Route::get('/danh-muc/sua/{id}', 'App\Http\Controllers\CategoryController@edit');
    Route::post('/danh-muc/sua/{id}', 'App\Http\Controllers\CategoryController@update');
    //Route::get('/danh-muc/xoa/{id}', 'App\Http\Controllers\CategoryController@destroy');
    Route::post('/danh-muc/xoa', 'App\Http\Controllers\CategoryController@destroy');
    Route::post('/danh-muc/cap-nhat-trang-thai', 'App\Http\Controllers\CategoryController@updateStatus');

    //sub category admin
    Route::get('/danh-muc-con/hien-thi', 'App\Http\Controllers\SubCategoryController@index');
    Route::get('/danh-muc-con/them-moi', 'App\Http\Controllers\SubCategoryController@create');
    Route::post('/danh-muc-con/them-moi', 'App\Http\Controllers\SubCategoryController@store');
    Route::get('/danh-muc-con/sua/{id}', 'App\Http\Controllers\SubCategoryController@edit');
    Route::post('/danh-muc-con/sua/{id}', 'App\Http\Controllers\SubCategoryController@update');
    Route::get('/danh-muc-con/xoa/{id}', 'App\Http\Controllers\SubCategoryController@destroy');

    //product admin
    Route::get('/san-pham/hien-thi', 'App\Http\Controllers\ProductController@index');
    Route::get('/san-pham/them', 'App\Http\Controllers\ProductController@create');
    Route::post('/san-pham/them', 'App\Http\Controllers\ProductController@store');
    Route::get('/san-pham/sua/{id}', 'App\Http\Controllers\ProductController@edit');
    Route::post('san-pham/sua/{id}', 'App\Http\Controllers\ProductController@update');
    Route::get('/san-pham/xoa/{id}', 'App\Http\Controllers\ProductController@destroy');
    Route::get('/san-pham/giam-gia', 'App\Http\Controllers\ProductController@discount');
    Route::post('/san-pham/giam-gia', 'App\Http\Controllers\ProductController@postDiscount');

    //slider admin
     Route::get('/slider/hien-thi', 'App\Http\Controllers\SliderController@index');
    Route::get('/slider/them', 'App\Http\Controllers\SliderController@create');
     Route::post('/slider/them', 'App\Http\Controllers\SliderController@store');
     Route::get('/slider/sua/{id}', 'App\Http\Controllers\SliderController@edit');
    Route::post('/slider/sua/{id}', 'App\Http\Controllers\SliderController@update');
    Route::get('/slider/xoa/{id}', 'App\Http\Controllers\SliderController@destroy');


    //notification
    Route::get('/thong-bao', 'App\Http\Controllers\NotificationController@notification');

    //order
    Route::get('/don-hang/don-hang-moi', 'App\Http\Controllers\OrderController@newOrder');
    Route::get('/don-hang/don-hang-dang-giao', 'App\Http\Controllers\OrderController@shippingOrder');
    Route::get('/don-hang/xac-nhan/{id}', 'App\Http\Controllers\OrderController@confirmOrder');
    Route::get('/don-hang/hoan-thanh/{id}', 'App\Http\Controllers\OrderController@successOrder');
    Route::get('/don-hang/don-hang-da-giao', 'App\Http\Controllers\OrderController@order');
    Route::post('/don-hang/xac-nhan', 'App\Http\Controllers\OrderController@confirmOrderPost');
    Route::get('/don-hang/chi-tiet/{id}', 'App\Http\Controllers\OrderController@detail');
    Route::get('/don-hang/in-hoa-don/{id}', 'App\Http\Controllers\OrderController@print');
    Route::get('/pdfview/{id}','App\Http\Controllers\OrderController@pdfview');
    Route::get('/don-hang/moi', 'App\Http\Controllers\OrderController@inMonth');

    //coupon
    Route::get('/ma-giam-gia/hien-thi', 'App\Http\Controllers\CouponAdminController@index');
    Route::get('/ma-giam-gia/them','App\Http\Controllers\CouponAdminController@create');
     Route::post('/ma-giam-gia/them', 'App\Http\Controllers\CouponAdminController@store');
     Route::get('/ma-giam-gia/sua/{id}', 'App\Http\Controllers\CouponAdminController@edit');
    Route::post('/ma-giam-gia/sua/{id}', 'App\Http\Controllers\CouponAdminController@update');
    Route::get('/ma-giam-gia/xoa/{id}', 'App\Http\Controllers\CouponAdminController@destroy');

    //thumbnail
    Route::get('/thumbnail/them','App\Http\Controllers\ThumbnailController@create');
     Route::post('/thumbnail/them', 'App\Http\Controllers\ThumbnailController@store');

    //filter
    Route::post('/loc', 'App\Http\Controllers\AdminController@filter');
    Route::post('/thang', 'App\Http\Controllers\AdminController@filterMonth');
    Route::post('/box', 'App\Http\Controllers\AdminController@box');
});
// Route::get('admin/login','App\Http\Controllers\LoginController@getLogin')->middleware('checkLogin');
// Route::post('admin/login','App\Http\Controllers\LoginController@postLogin' );
// Route::get('admin/logout','App\Http\Controllers\LoginController@logout');
// Route::get('admin/login-google','App\Http\Controllers\LoginController@login_google');
// Route::get('admin/google/callback','App\Http\Controllers\LoginController@callback_google');
// Route::get('admin/login-facebook','App\Http\Controllers\LoginController@login_facebook');
// Route::get('admin/facebook/callback',
// 	'App\Http\Controllers\LoginController@callback_facebook');

Route::get('test', function() {
    $product=ProductModel::find(95);
    // if(isKM($product->bdkm,$product->ktkm))
    // {
    //     echo "a";
    // }
    // var_dump($product->bdkm);
    isKM($product->bdkm,$product->ktkm);
});		