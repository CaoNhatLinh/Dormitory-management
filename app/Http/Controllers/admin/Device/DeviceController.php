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

class DeviceController extends Controller
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
            'linkjs' => [],
            'css' => [
                'css/device.css',
                'css/plugins/dataTables/datatables.min.css',
                'css/plugins/footable/footable.core.css',
            ],
            'linkcss' => [],

            'script' => [
                '
                $(document).ready(function(){
                    var table = $(\'.dataTables-example\').DataTable({
                        pageLength: 10,
                        lengthChange: true,
                        responsive: true,
                        info: false,
                        ordering: true,
                        paging: true,
                        dom: \'<"html5buttons"B>lTfgitp\',
                        buttons: [
                            {
                                extend: \'print\',
                                customize: function (win){
                                    $(win.document.body).addClass(\'white-bg\');
                                    $(win.document.body).css(\'font-size\', \'10px\');
            
                                    $(win.document.body).find(\'table\')
                                        .addClass(\'compact\')
                                        .css(\'font-size\', \'inherit\');
                                },
                                exportOptions: {
                                    columns: \':not(:last-child)\'
                                }
                            }
                        ],
                        columnDefs: [{
                            orderable: false,
                            targets: -1
                        }]
                    });
                });
                '
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
            $devices = Device::with('deviceType')->get();
            $data = ['devices' => $devices];
            $title = 'Device list';
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $config = $this->config();
            $template = 'admin.device.index';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'data',
                'title',
                'employee',
                'position_name',
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
                $user = User::find($authId)->with('employee');
                $employee = Employee::find($user->employee_id);
                $employee_id = $user->employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $deviceTypes = DeviceType::all();
            $deviceTypes->prepend((object)['device_type_id' => -1, 'device_type_name' => '']);
            $title = 'Create Device';
            $config = $this->config();
            $template = 'admin.device.create';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'deviceTypes',
                'title',
                'employee',
                'position_name',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
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
    public function editView($id)
    {
        if (Auth::check()) {
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId)->with('employee');
                $employee = Employee::find($user->employee_id);
                $employee_id = $user->employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $device = device::find($id);
            $deviceTypes = deviceType::all();

            $title = 'Update device';
            $config = $this->config();
            $template = 'admin.device.edit';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'device',
                'deviceTypes',
                'title',
                'employee',
                'position_name',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function edit(Request $request, $id)
    {
        $device = device::find($id);
        $request->validate([
            'device_name' => 'required|max:255|unique:devices,device_name,' . $id . ',device_id',
            'quantity' => 'required|integer|min:0',
            'original_price' => 'required|numeric|min:0',
            'device_type_id' => 'required|exists:device_types,device_type_id',
        ]);

        $device->device_name = $request->device_name;
        $device->device_type_id = $request->device_type_id;
        $device->quantity = $request->quantity;
        $device->original_price = $request->original_price;
        $device->save();

        return redirect()->route('device.index');
    }
    public function search(Request $request)
    {

        if (Auth::check()) {
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId)->with('employee');
                $employee = Employee::find($user->employee_id);
                $employee_id = $user->employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $devices = Device::with('deviceType')
                    ->where('device_name', 'like', "%$keyword%")
                    ->orWhere('device_id', 'like', "%$keyword%")
                    ->orWhere('quantity', 'like', "%$keyword%")
                    ->orWhere('original_price', 'like', "%$keyword%")
                    ->orWhereHas('deviceType', function ($query) use ($keyword) {
                        $query->where('device_type_name', 'like', "%$keyword%");
                    })->get();
            } else {
                $devices = Device::with('deviceType')->get();
            }

            $data = ['devices' => $devices];
            $title = 'Search Results';
            $config = $this->config();
            $template = 'admin.device.index';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'data',
                'title',
                'employee',
                'position_name',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function delete($id)
    {
        $device = Device::find($id);

        if (!$device) {
            return redirect()->route('device.index')->with('error', 'Device not found!');
        }

        $device->delete();

        return redirect()->route('device.index')->with('success', 'Device deleted successfully!');
    }
}
