<?php

namespace App\Http\Controllers\Auth\Seller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:seller')->except('logout');
    }

    /*
     * Phương thức này trả về view dùng để đăng nhập seller
     * */

    public function login(){
        return view('seller.auth.login');
    }


    /*
     * Phương thức này dùng dể đăng nhập cho seller
     * Lấy thông tin từ form có METHOD là POST
     *
     * */

    public function loginSeller(Request $request){

        // Validate giá trị
        $this -> validate($request, array(
            'email' => 'required|email',
            'password' => 'required|min:6'

        ));

        // Đăng nhập

        if (Auth::guard('seller')->attempt(
            ['email' => $request->email, 'password' => $request->password], $request->remember
        )){

            // Nếu đăng nhập thành công thì sẽ chuyển hàng về view dashboard của seller
            return redirect()->intended(route('seller.dashboard'));
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

        Auth::guard('seller')->logout();

        // Sau khi đăng xuất sẽ chuyển hướng về trang login của seller
        return redirect()->route('seller.auth.login');

    }
}
