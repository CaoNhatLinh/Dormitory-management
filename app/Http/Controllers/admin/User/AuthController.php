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

    public function index()
    {
        if (Auth::id() > 0) {
            return redirect()->route('dashboard.index')->with('succes', 'dăng nhập thành công');
        }

        return view('admin.user.auth.login');
    }

    public function login(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
       
        if (Auth::attempt($credentials, $request->input('remember'))) {
            return redirect()->route('dashboard.index')->with('succes', 'Domitory management system', 'Welcome');
        }
        return redirect()->back()->with('error', 'email hoặc mật khẩu không chính xác');
    }
    
 
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.admin');
    }
    
}
