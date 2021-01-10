<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use App\Rules\Captcha; 
use Session;
use App\Models\SocialModel; //sử dụng model Social
use Socialite; //sử dụng Socialite
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\Mail\ForgotPW;
use Illuminate\Support\Facades\URL;

class LoginController extends PageController
{
    public function getLogin()
    {
        // $user=AdminModel::all();
        // dd($user);
    	return view('login');
    }
    public function postLogin(Request $request)
    {
    	$this->validate($request,
			[
				'email'=>'required|email',
				'password'=>'required',
                'g-recaptcha-response' => new Captcha(),        //dòng kiểm tra Captcha
			],
			[
				'email.required'=>'Bạn phải nhập email',
				'email.email'=>'Email sai định dạng',
				'password.required'=>'Bạn phải nhập mật khẩu',
			]);
    	$pw=md5($request->password);
    	$user=CustomerModel::where('customer_email',$request->email)->where('customer_password',$pw)->first();
    	if($user)
    	{
            if($user->verify==0)
            {
                $thongbao="Email chưa được xác nhận";
                return redirect('dang-nhap')->with(compact('thongbao'));
            }
            else
            {
                if($user->status==1)
                    {
                        if($user->customer_avatar!="")
                        {
                            Session::put('admin_avatar',$user->customer_avatar);
                        }
                        Session::put('admin_name',$user->customer_name);
                        Session::put('admin_id',$user->id);
                        return redirect('admin/dashboard');
                        
                    }
                else
                    {
                        Session::put('customer_name',$user->customer_name);
                        Session::put('customer_id',$user->id);
                         Session::put('customer',$user);
                        return redirect('/#');
                        
                    }  
            }
    	}
    	else
    	{
            $thongbao="Tài khoản hoặc mật khẩu không chính xác";
    		return redirect('dang-nhap')->with(compact('thongbao'));
    	}
    }
    public function logout()
    {
    	Session::flush();
    	return redirect('dang-nhap');
    }
    public function getSignIn()
    {
        return view('signin');
    }
    public function postSignIn(Request $request)
    {
        $this->validate($request,
            [
                'email'=>'required|email
                ',
                
                'password'=>'required',
                //'g-recaptcha-response' => new Captcha(),        //dòng kiểm tra Captcha
                //|unique:customer,customer_email
                'name'=>'required',
                
            ],
            [
                'email.required'=>'Bạn phải nhập email',
                'email.email'=>'Email sai định dạng',
                //'email.unique'=>'Email đã tồn tại',
                'password.required'=>'Bạn phải nhập mật khẩu',
                'email.unique'=>'Email đã được sử dụng',
                'name.required'=>'Bạn phải điền vào tên của bạn'
            ]);
        $new_user=new CustomerModel;
        $new_user->customer_name=$request->name;
        $new_user->customer_phone=$request->phone;
        $new_user->customer_email=$request->email;
        $new_user->customer_password=md5($request->password);
        $new_user->status=0;
        $new_user->verify=0;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $new_user->created_at = now();
        $new_user->updated_at = now();
        $new_user->save();
        // $user=CustomerModel::where('customer_email',$request->email)->first();
        
        $email=$request->email;
        $link=URL::temporarySignedRoute('verify', now()->addMinutes(30), ['id' =>$new_user->id]);
        //$link="http://ekaopiz.vn/verify/".$user->id;
        Mail::to($new_user->customer_email)->send(new VerifyEmail($email,$link));
        $thongbao="Đăng kí thành công!Vui lòng xác nhận email của bạn";
        return redirect('dang-ki')->with(compact('thongbao'));
    }
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
        
        $authUser = $this->findOrCreateUser($users,'google');
        $account_name =CustomerModel::where('id',$authUser->user)->first();
        Session::put('customer_name',$account_name->customer_name);
        Session::put('customer_id',$account_name->id);
        
        return redirect('/')->with('message', 'Đăng nhập thành công');
      /*$user = Socialite::driver('google')->user();

            $finduser = AdminModel::where('admin_email', $user->email)->first();

            if($finduser){

                Session::put('admin_name',$finduser->admin_name);
                Session::put('admin_id',$finduser->admin_id);
        

                return redirect('admin/dashboard');

            }
            else{
                $new_user = AdminModel::create([
                    'admin_name' => $user->name,
                    'admin_email' => $user->email,
                    'admin_password' => '',
                    'admin_id'=> $user->id,
                    'admin_phone' => '',
                    'admin_status' => 1
                ]);
                $new_user->save();
                //$finduser = AdminModel::where('admin_email', $new_user->email)->first();
                
                Session::put('admin_name',$new_user->admin_name);
                Session::put('admin_id',$new_user->admin_id);
            
                return redirect('admin/dashboard');
            }*/
       
    }
    public function findOrCreateUser($users,$provider){
        $authUser = SocialModel::where('provider_user_id', $users->id)->first();
        
        if($authUser){

            return $authUser;
        }
      
        $new_user = new SocialModel([
            'provider_user_id' => $users->id,
            'provider' => strtoupper($provider)
        ]);

        $orang = CustomerModel::where('customer_email',$users->email)->first();

            if(!$orang){
                $orang = CustomerModel::create([
                    'customer_name' => $users->name,
                    'customer_email' => $users->email,
                    'customer_password' => '',
                    'verify'=>1,
                    'customer_phone' => '',
                    'status' => 0
                ]);
            }
        $new_user->login()->associate($orang);
        $new_user->save();
        return $new_user;
        /*$account_name = AdminModel::where('admin_id',$new_user->user)->first();
        Session::put('admin_name',$account_name->admin_name);
        Session::put('admin_id',$account_name->admin_id);
        Session::put('user',$account_name);
        return redirect('admin/dashboard')->with('message', 'Đăng nhập Admin thành công');*/


    }
    // public function login_facebook(){
    //     return Socialite::driver('facebook')->redirect();
    // }

    // public function callback_facebook(){
    //     $provider = Socialite::driver('facebook')->stateless()->user();
    //     $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
    //     if($account){
    //         //login in vao trang quan tri  
    //         $account_name = AdminModel::where('admin_id',$account->user)->first();
    //         Session::put('admin_name',$account_name->admin_name);
    //         Session::put('admin_id',$account_name->admin_id);
    //         return redirect('/admin/dashboard')->with('message', 'Đăng nhập Admin thành công');
    //     }else{

    //         $hieu = new Social([
    //             'provider_user_id' => $provider->getId(),
    //             'provider' => 'facebook'
    //         ]);

    //         $orang = AdminModel::where('admin_email',$provider->getEmail())->first();

    //         if(!$orang){
    //             $orang = AdminModel::create([
    //                 'admin_name' => $provider->getName(),
    //                 'admin_email' => $provider->getEmail(),
    //                 'admin_password' => '',
    //                 'admin_status' => 1

    //             ]);
    //         }
    //         $hieu->login()->associate($orang);
    //         $hieu->save();

    //         $account_name = AdminModel::where('admin_id',$hieu->user)->first();

    //         Session::put('admin_name',$account_name->admin_name);
    //          Session::put('admin_id',$account_name->admin_id);
    //         return redirect('/admin/dashboard')->with('message', 'Đăng nhập Admin thành công');
    //     } 
    // }
    public function verify($id)
    {
        $user=CustomerModel::find($id);
        $user->verify=1;
        $user->save();
        Session::put('customer_name',$user->customer_name);
        Session::put('customer_id',$user->id);
        Session::put('customer',$user);
        return redirect('/#');
    }

    public function forgotPW()
    {
        return view('email.inputEmail');
    }
    public function postForgotPW(Request $request)
    {
        $this->validate($request,
            [
                
                'new_pw'=>'required',
                'confirm_pw'=>'required|same:new_pw',
            ],
            [
                
                'new_pw.required'=>'Bạn phải nhập mật khẩu mới',
                'confirm_pw.required'=>'Bạn phải nhập xác nhận mật khẩu mới',
                'confirm_pw.same'=>'Mật khẩu xác nhận sai',
            ]);
        $id=$request->id;
        $customer=CustomerModel::find($id);
        $customer->customer_password=md5($request->new_pw);
        $customer->save();
        Session::put('customer_name',$customer->customer_name);
        Session::put('customer_id',$customer->id);
        Session::put('customer',$customer);
        return redirect('/');
    }
    public function inputEmail(Request $request)
    {
        $this->validate($request,
            [
                'email'=>'required|email',
            
            ],
            [
                'email.required'=>'Bạn phải nhập email',
                'email.email'=>'Email sai định dạng',
                
            ]);
        $customer=CustomerModel::where('customer_email',$request->email)->first();
        if($customer)
        {
            $id=$customer->id;
            $email=$customer->customer_email;
            $email=$request->email;
            $link=URL::temporarySignedRoute('verifyPW', now()->addMinutes(30), ['id' =>$id]);
            //$link="http://ekaopiz.vn/verify/".$user->id;
            Mail::to($email)->send(new ForgotPW($email,$link));
            $thongbao="Thành công!Vui lòng kiêm tra email trong hộp thư của bạn";
            return redirect('quen-mat-khau')->with(compact('thongbao'));
        }
        else
        {
            $thongbao="Email không tồn tại";
            return redirect('quen-mat-khau')->with(compact('thongbao'));
        }

    }
    public function verifyPW($id)
    {
        $id=$id;
        return view('email.changePW')->with(compact('id'));
    }


}



