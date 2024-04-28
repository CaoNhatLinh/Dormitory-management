<?php

namespace App\Http\Controllers\Admin\User;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $id = Auth::id();
            if ($user) {
                $user = User::find($id);
                $title = 'Profile';
                $employee = Employee::find($id);
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id) -> position_name;
                $config = $this->config();
                $template = 'admin.user.index';
                return view('admin.dashboard.layout', compact(
                    'template','title',
                    'config',
                    'user',
                    'employee',
                    'position_name'
                ));
            }
        } else {
            return view('admin.user.auth.login');
        }
    }
}
