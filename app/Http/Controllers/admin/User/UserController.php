<?php

namespace App\Http\Controllers\Admin\User;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
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
                // 'css/plugins/footable/footable.core.css'
            ],
            'linkcss' => [],

            'script' => [
                '$(document).ready(function() {

                    $(\'.footable\').footable();
                    $(\'.footable2\').footable();
        
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
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $employee = Employee::find($authId);
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
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
            ));
        }
        else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }
    public function profileView()
    {
        if (Auth::check()) {
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $employee = Employee::find($authId);
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Auth::user();
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
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }

    public function createView()
    {
        if (Auth::check()) {
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $employee = Employee::find($authId);
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');

            $title = 'Create user';

            $config = $this->config();

            $template = 'admin.user.create';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }
    
}
