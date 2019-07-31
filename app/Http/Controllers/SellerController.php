<?php

namespace App\Http\Controllers;

use App\Model\SellerModel;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /*
     * Hàm khởi tạo của class sẽ được chạy ngay khi khởi tạo đối tượng.
     * Tức là hàm này luôn được chạy trước các hàm khác trong class.
     * SellerController Construct
     *
     * */
    public function __construct()
    {
        $this->middleware('auth:seller')->only('index');
    }

    /*
     * Phương thức trả về khi đăng nhập seller thành công
     * */

    public function index(){
        return view('seller.dashboard');
    }

    /*
     * Phương thức trả về view dùng để đăng ký tài khoản seller
     * */
    public function create(){
        return view('seller.auth.register');
    }

    public function store(Request $request)
    {


        // Validate dữ liệu được gửi từ form đi

        $this->validate($request, array(
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',

        ));

        // Khởi tạo model để lưu admin mới

        $sellerModel = new SellerModel();
        $sellerModel->name = $request->name;
        $sellerModel->email = $request->email;
        $sellerModel->password = bcrypt($request->password);


        $sellerModel->save();


        // @todo
        return redirect()->route('seller.auth.login');
    }
}
