<?php

namespace App\Http\Controllers\admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        
    }
   
    public function index(){
        return view('admin.user.auth.login');
     }  
     public function login(AuthRequest $request){
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];
        
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index')->with('succes','dăng nhập thành công');
           
        }
        return redirect()->route('auth.admin')->with('error','username hoặc mật khẩu không chính xác');
     }    
}
    