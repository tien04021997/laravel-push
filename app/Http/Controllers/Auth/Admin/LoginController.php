<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController extends Controller
{
    //


    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /*
     * Phương thức này trả về view dùng để đăng nhập admin
     * */

    public function login(){
        return view('admin.auth.login');
    }

    /*
     * Phương thức này dùng dể đăng nhập cho admin
     * Lấy thông tin từ form có METHOD là POST
     *
     * */

    public function loginAdmin(Request $request){

        // Validate giá trị
        $this -> validate($request, array(
           'email' => 'required|email',
            'password' => 'required|min:6'

        ));

        // Đăng nhập

        if (Auth::guard('admin')->attempt(
            ['email' => $request->email, 'password' => $request->password], $request->remember
        )){

            // Nếu đăng nhập thành công thì sẽ chuyển hàng về view dashboard của admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // nếu đăng nhập thất bại thì sẽ quay về ô đăng nhập
        // Với giá trị của 2 ô input cũ là email và remember

        return redirect()->back()->withInput($request->only('email', 'remember'));

    }

    /*
     *
     * Phương thức này dùng để đăng xuất
     * */

    public function logout(){

        Auth::guard('admin')->logout();

        // Sau khi đăng xuất sẽ chuyển hướng về trang login của admin
        return redirect()->route('admin.auth.login');

    }
}
