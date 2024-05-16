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
                'js/plugins/flot/jquery.flot.js',
                'js/plugins/flot/jquery.flot.js',
                'js/plugins/flot/jquery.flot.tooltip.min.js',
                'js/plugins/flot/jquery.flot.spline.js',
                'js/plugins/flot/query.flot.resize.js',
                'js/plugins/flot/query.flot.resize.js',
                'js/plugins/flot/jquery.flot.pie.js',
                'js/plugins/peity/jquery.peity.min.js',
                'js/demo/peity-demo.js',
                'js/inspinia.js',
                'js/plugins/gritter/jquery.gritter.min.js',
                'js/demo/sparkline-demo.js',
                'js/plugins/sparkline/jquery.sparkline.min.js',
                'js/plugins/chartJs/Chart.min.js',
                'js/plugins/toastr/toastr.min.js',

            ],
            'css' => [
                'css/profile.css'
                ]
        ];
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
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }
}
