<?php

namespace App\Http\Controllers\Admin\User;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

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
                'js/device.js',
                'js/plugins/dataTables/datatables.min.js',
                'js/plugins/pace/pace.min.js',
                'js/plugins/footable/footable.all.min.js',
            ],
            'linkjs' => [
              
            ],
            'css' => [
                'css/device.css',
            ],  
            'linkcss' => [
               
            ],
            
            'script' => [
                
                '
                $(document).ready(function(){
                    $(\'.dataTables-example\').DataTable({
                        pageLength: 4,
                        searching: false, 
                        ordering: false, 
                        responsive: true,
                        info: false,  
                        paging: true,
                        lengthChange: false
                    });
        
                });
                ',
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
        if(Auth::check())
        {
            $users=User::with('permission', 'employee')->get();
            $data = ['users' => $users];
            $id = Auth::id();
            $title = 'User list';
            $employee = Employee::find($id);
            $employee_id = $employee->employee_id;
            $position_name = Position::find($employee_id)->position_name;
    
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
            $user = Auth::user();
            $id = Auth::id();
            if ($user) {
                $user = User::find($id);
                $title = 'Profile';
                $employee = Employee::find($id);
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id) -> position_name;
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

    
}
