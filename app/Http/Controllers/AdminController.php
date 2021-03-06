<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Order;
use App\DoanhThu;
use Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
    
    	return view('admin.dashboard');
    }
    public function login(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$data=$request->all();
    		if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])) {
    			// Session::put('adminSession',$data['email']);
    			return view('/admin/dashboard');
    		}
    		else
    		{
    			return redirect()->back()->with('error','Tài khoản hoặc mật khẩu không đúng');
    		}
    	}
    	return view('admin.admin_login');
    }
    public function logout()
    {
    	Session::flush();
    	return redirect('/admin')->with('success','Đăng xuất thành công');
    }
    public function caidat()
    {
    	return view('admin.settings');
    }
    public function checkpass()
    {
    	$data=$request->all();
    	$mk_hientai=$data['mk_hientai'];
    	$check_mk=User::where(['admin'=>'1'])->first();
    	if (Hash::check($mk_hientai,$check_mk->password)) {
    	    echo "true";die;
    	}
    	else
    	{
    		echo "false";die;
    	}
    }
    public function suapass(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$data=$request->all();
    		$check_mk=User::where(['email'=>Auth::user()->email])->first();
    		$mk_hientai=$data['mk_hientai'];
    		if (Hash::check($mk_hientai,$check_mk->password)) {
    	    $password=bcrypt($data['mk_moi']);
    	    User::where('id','2')->update(['password'=>$password]);
    	    return redirect('/admin/caidat')->with('success','Cập nhật mật khẩu thành công');
    	}
    	else
    	{
    		return redirect('/admin/caidat')->with('error','Sai mật khẩu hiện tại');
    	}
    	}
    }
    public function chart_doanhthu()
    {
        $order=Order::with('order')->get();
        $t12=DoanhThu::where('tháng',"12")->first();
        
        return view("bieudo.chart_doanhthu")->with(compact('order','t12'));
    }
}
