<?php

namespace App\Http\Controllers\Admin\User;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\error;

class UserController extends Controller
{
    public function __construct()
    {
    }
    public function config()
    {

        return $config = [
            'js' => [

                'js/plugins/pace/pace.min.js',
                'js/plugins/footable/footable.all.min.js'

            ],
            'linkjs' => [],
            'css' => [
                'css/plugins/footable/footable.core.css'
            ],
            'linkcss' => [],

            'script' => [
                '$(document).ready(function() {

                    $(\'.footable\').footable();
        
                });',
            ]


        ];
    }
    public function configProfile()
    {
        return $config = [
            'js' => [
                

            ],
            'linkjs' => [
                
            ],
            'css' => [
                'css/profile.css'
            ],
            'linkcss' => [
                
            ],
            'script' => [
                '$(function() {
                    $(\'#profile-image1\').on(\'click\', function() {
                        $(\'#profile-image-upload\').click();
                    });
                });'
            ]
        ];
    }

    public function index()
    {
       
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId);
                $employee = $user->employee;
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $users=User::with('permission', 'employee')->get();
            $data = ['users' => $users];
            $title = 'User list';
            $config = $this->config();
            $template = 'admin.user.index';
    
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'data',
                'title',
                'employee',
                'position_name',
                'user'
            ));
        }
        else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function profileView()
    {
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId);
                $employee = $user->employee;
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $id = Auth::id();
            if ($user) {
                $user = User::find($id);
                $title = 'Profile';
                $config = $this->configProfile();
                $template = 'admin.user.profile';
                return view('admin.dashboard.layout', compact(
                    'template','title',
                    'config',
                    'user',
                    'employee',
                    'position_name'
                ));
            }
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function createView()
    {
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId);
                $employee = $user->employee;
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');

            $title = 'Create user';

            $config = $this->config();
            $employees = Employee::all();
            $template = 'admin.user.create';
            $permissions = Permission::all();
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'employees',
                'permissions',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'employee_id' => 'required|integer',
            'permission_id' => 'required|integer',
        ]);
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->employee_id = $request->employee_id;
        $user->permission_id = $request->permission_id;
        $result = $user->save();
        if ($result) {
            return redirect()->route('user.index')->with('success', 'user created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create user.');
        }
    }
    public function editView($id)
    {
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId);
                $employee = $user->employee;
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $title = 'Edit user';
            $config = $this->config();
            $employees = Employee::all();
            $template = 'admin.user.edit';
            $permissions = Permission::all();
            $userEdit = User::find($id);
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'employees',
                'permissions',
                'user',
                 'userEdit'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'employee_id' => 'required|integer',
            'permission_id' => 'required|integer',
        ]);
        $user = User::find($id);
        $user->email = $request->email;
        $user->employee_id = $request->employee_id;
        $user->permission_id = $request->permission_id;
        $result = $user->save();
        if ($result) {
            return redirect()->route('user.index')->with('success', 'user edited successfully.');
        } else {
            return redirect()->back()->with('error', 'user to update fails.');
        }
    }
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found!');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully!');
    }

    public function resetpassword($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found!');
        }
        $user->password = Hash::make(123456);
        $result = $user->save();
        if ($result) {
            return redirect()->route('user.index')->with('success', 'password to reset successfully.');
        } else {
            return redirect()->back()->with('error', 'password to reset fail.');
        }
        return redirect()->route('user.index')->with('success', 'password to reset successfully!');
    }
}
