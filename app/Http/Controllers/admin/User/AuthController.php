<?php

namespace App\Http\Controllers\admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Session;

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
            $authId = Auth::id();
                $user = User::find($authId);
                $employee = $user->employee;
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            return redirect()->route('dashboard.index')->with('succes', 'Domitory management system', 'Welcome');
        }
        else
        {
            return redirect()->back()->with('error', 'email hoặc mật khẩu không chính xác');
        }
        
    }

    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Session::forget('employee');
        Session::forget('position_name');
        Session::forget('user');
        return redirect()->route('auth.admin');
    }
}
