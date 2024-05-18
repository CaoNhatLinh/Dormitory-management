<?php
namespace App\Http\Controllers\Admin\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function __construct()
    {
    }

    public function config()
    {
        return $config = [
            'js' => [
                
            ],
            'linkjs' => [
                
            ],
            'css' => [
            ],
            'linkcss' => [
                
            ],
            'script' =>[
            ]
        ];
    }
   
    public function index()
    {
        if(Auth::check())
        {
            $devices = Device::all();
            $data = ['devices' => $devices];
    
            $id = Auth::id();
            $title = 'Device';
    
            $employee = Employee::find($id);
            $employee_id = $employee->employee_id;
            $position_name = Position::find($employee_id)->position_name;
    
            $config = $this->config();
            $template = 'admin.device.index';
    
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'data',
                'title',
                'employee',
                'position_name'
            ));
        }
        else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }
}
