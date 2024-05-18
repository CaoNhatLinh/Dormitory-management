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
            // $devices = Device::all();
            $devices=Device::with('deviceType')->get();
            $data = ['devices' => $devices];
            $id = Auth::id();
            $title = 'Device list';
    
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
    public function createView()
    {
        $deviceTypes = DeviceType::all();
        $deviceTypes->prepend((object)['device_type_id' => -1, 'device_type_name' => '']);
        $id = Auth::id();
        $title = 'Create Device';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.device.create';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'deviceTypes',
            'title',
            'employee',
            'position_name'
        ));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'device_name' => 'required|max:255|unique:devices,device_name',
            'quantity' => 'required|integer|min:0',
            'original_price' => 'required|numeric|min:0',
            'device_type_id' => 'required|exists:device_types,device_type_id',
        ]);

        $device = new Device;
        $device->device_name = $validatedData['device_name'];
        $device->quantity = $validatedData['quantity'];
        $device->original_price = $validatedData['original_price'];
        $device->device_type_id = $validatedData['device_type_id'];
        $device->save();
        return redirect()->route('device.index')->with('success', 'Device created successfully!');
    }
    
}
