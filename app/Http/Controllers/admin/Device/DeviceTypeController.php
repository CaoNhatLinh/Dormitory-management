<?php
namespace App\Http\Controllers\Admin\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DeviceTypeController extends Controller
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
                'https://cdn.tailwindcss.com'
            ],
            'css' => [
                
            ],
            'linkcss' => [
               
            ],
            
            'script' =>[
                '
                tailwind.config = {
                    prefix: \'tw-\',
                    corePlugins: {
                        preflight: false, // Set preflight to false to disable default styles
                    },
                }',
            ]
        ];
    }
   
    public function index()
    {
        if(Auth::check())
        {
            $deviceTypes = DeviceType::all();
            $data = ['deviceTypes' => $deviceTypes];
    
            $id = Auth::id();
            $title = 'Device Type';
    
            $employee = Employee::find($id);
            $employee_id = $employee->employee_id;
            $position_name = Position::find($employee_id)->position_name;
    
            $config = $this->config();
            $template = 'admin.device.devicetype.index';
    
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
    public function createView()
    {
        $id = Auth::id();
        $title = 'Create device type';
        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;
        $config = $this->config();

        $template = 'admin.device.devicetype.create';


        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name'
        ));
    }

    public function create(Request $request)
    {
        $request->validate([
            'device_type_name' => 'required|unique:device_types',
        ]);

        $deviceType = new DeviceType();
        $deviceType->device_type_name = $request->device_type_name;
        $deviceType->save();

        return redirect()->route('deviceType.index')->with('success', 'Device Type created successfully!');
    }
    public function editView($id)
    {
        $authId = Auth::id();
        $title = 'Edit device type';
        $employee = Employee::find($authId);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;
        $config = $this->config();

        $template = 'admin.device.devicetype.edit';

        $deviceType = deviceType::find($id);

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name',
            'deviceType'
        ));
    }

    public function edit(Request $request, $id)
    {
        $deviceType = deviceType::find($id);
        $request->validate([
            'device_type_name' => [
                'required',
                Rule::unique('device_types', 'device_type_name')->ignore($deviceType->device_type_name, 'device_type_name'),
            ],
        ]);
        $deviceType->device_type_name = $request->device_type_name;
        $result = $deviceType->save();
        return redirect()->route('deviceType.index');
    }
}
