<?php

namespace App\Http\Controllers\Admin\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class DeviceTypeController extends Controller
{
    public function __construct()
    {
    }

    public function config()
    {
        return $config = [
            'js' => [],
            'linkjs' => [
                'https://cdn.tailwindcss.com'
            ],
            'css' => [],
            'linkcss' => [],

            'script' => [
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
            $deviceTypes = DeviceType::all();
            $data = ['deviceTypes' => $deviceTypes];
            $title = 'Device Type';
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
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
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
            $title = 'Create device type';
            $config = $this->config();

            $template = 'admin.device.devicetype.create';


            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
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
        if (Auth::check()) {
            if (!Session::has('user')&& !Session::has('employee') && !Session::has('position_name')) {
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
            $title = 'Edit device type';
            $config = $this->config();

            $template = 'admin.device.devicetype.edit';

            $deviceType = deviceType::find($id);

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'deviceType',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
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
