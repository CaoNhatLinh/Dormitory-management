<?php

namespace App\Http\Controllers\admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        if (Auth::id() > 0) {
            return redirect()->route('dashboard.index');
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
        } else {
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

    public function forgetPass()
    {
        if (Auth::id() > 0) {
            return redirect()->route('dashboard.index');
        }
        return view('admin.user.auth.forgetpass');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $otp = mt_rand(100000, 999999);
        $user = User::where('email', $request->email)->first();
        $user->otp = $otp;
        $user->save();
        Mail::to($request->email)->send(new ResetPasswordMail($otp));
        return redirect()->route('password.otp')->with([
            'message' => 'An email with OTP has been sent to your email address.',
            'email' => $request->email,
        ]);
    }
    public function showOTP(Request $request)
    {
        $email = session('email');
        if (!$email) {
            return redirect()->route('auth.forgetPass')->with('error', 'Email not found in session.');
        }
        return view('admin.user.auth.otp', compact('email'));
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
        if ($user) {
            return redirect()->route('password.resetView')->with('email', $request->email);
        } else {
            return redirect()->back()->withErrors(['otp' => 'Invalid OTP']);
        }
    }
    public function resetView(Request $request)
    {
        $email = session('email');
        if (!$email) {
            return redirect()->route('auth.forgetPass')->with('error', 'Email not found in session.');
        }
        return view('admin.user.auth.reset', compact('email'));
    }
    public function updatePassword(Request $request)
    {
    
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|',
            'repassword' => 'required|string|min:6|',
        ]);
        $password = $request->password;
        $repassword = $request->repassword;
        if ($password != $repassword) {
            return redirect()->back()->with('error', 'Re-password do not match');
        }
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error','No user found with this email address.');
        }
        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->save();
        return redirect()->route('auth.admin')->with('succes', 'Your password has been reset successfully. Please log in with your new password.');
    }
}
