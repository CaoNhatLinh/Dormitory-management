<?php

namespace App\Http\Controllers\Admin\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceRentalDetail;
use App\Models\DeviceRental;
use App\Models\DeviceType;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            'linkjs' => [
                'https://cdn.tailwindcss.com'
            ],
            'css' => [
                'css/device.css',
                'css/plugins/dataTables/datatables.min.css',
                'css/plugins/footable/footable.core.css',
            ],
            'linkcss' => [],

            'script' => [
                '
                tailwind.config = {
                    prefix: \'tw-\',
                    corePlugins: {
                        preflight: false, // Set preflight to false to disable default styles
                    },
                }',
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
            $devices = Device::with('deviceType')->get();
            foreach ($devices as $device) {
                $rentalQuantity = DeviceRentalDetail::where('device_id', $device->device_id)->count();
                $device->rental_quantity = $rentalQuantity;
            }
            $data = ['devices' => $devices];
            $title = 'Device list';
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

        return redirect()->route('device.index')->with('success', 'Device  updated successfully.');;
    }
    public function search(Request $request)
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
    
        try {
            $device->delete();
            return redirect()->route('device.index')->with('success', 'Device deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('device.index')->with('error', 'Error deleting device ');
        }
    }    
    public function loadExcel(Request $request)
    {
        $request->validate([
            'excel_device' => 'required|file|mimes:xlsx,xls,csv',
        ]);
    
        if ($request->hasFile('excel_device')) {
            $file = $request->file('excel_device');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
            $excel_devices = json_decode($request->query('excel_devices', '[]'), true);
    
            for ($row = 2; $row <= $highestRow; ++$row) {
                $excel_devices[] = [
                    'device_name' => $sheet->getCell('A' . $row)->getValue(),
                    'quantity' => $sheet->getCell('B' . $row)->getValue(),
                    'original_price' => $sheet->getCell('C' . $row)->getValue(),    
                    'device_type_id' => $sheet->getCell('D' . $row)->getValue(),
                ];
            }
    
            return redirect()->route('device.createExcelView', ['excel_devices' => json_encode($excel_devices)])->with('success', 'File processed successfully');
        } else {
            return redirect()->route('device.createExcelView')->with('error', 'File not found');
        }
    }    

    public function createExcelView(Request $request)
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
            $title = 'Create device from excel';
    
            $config = $this->config();
            $template = 'admin.device.importExcel';
    
            $excel_devices = json_decode($request->query('excel_devices', '[]'), true);
    
            $json = json_encode($excel_devices);
    
            $config = [
                'js' => [
                    'js/plugins/jqGrid/jquery.jqGrid.min.js',
                    'js/plugins/jquery-ui/jquery-ui.min.js'
                ],
                'linkjs' => [
                    'https://cdn.tailwindcss.com'
                ],
                'css' => [
                    'css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css',
                    'css/plugins/jqGrid/ui.jqgrid.css',
                ],
                'linkcss' => [],
    
                'script' => [
                    '
                    tailwind.config = {
                        prefix: \'tw-\',
                        corePlugins: {
                            preflight: false,
                        },
                    }',
                    '
                    $("#table_list_1").jqGrid({
                        data:  JSON.parse(\'' . $json . '\'),
                        datatype: "local",
                        height: 250,
                        autowidth: true,
                        shrinkToFit: true,
                        rowNum: 14,
                        rowList: [10, 20, 30],
                        colNames: [\'Device Name\', \'Quantity\',\'Original Price\', \'Device Type\'],
                        colModel:  [
                            {name: \'device_name\', index: \'device_name\', width: 150},
                            {name: \'quantity\', index: \'quantity\', width: 150},
                            {name: \'original_price\', index: \'original_price\', width: 150},
                            {name: \'device_type_id\', index: \'device_type_id\', width: 150},
                        ],
                        pager: "#pager_list_1",
                        viewrecords: true,
                        caption: "Device List",
                        hidegrid: false
                    });
                    $(window).bind(\'resize\', function () {
                        var width = $(\'.jqGrid_wrapper\').width();
                        $(\'#table_list_1\').setGridWidth(width);
                    });
                    '
                ]
            ];
    
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'excel_devices',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    

    public function createExcel(Request $request)
    {
        $excel_devices = json_decode($request->input('excel_devices', '[]'), true);
    
        if (empty($excel_devices)) {
            return redirect()->route('device.createExcelView')->with('error', 'No devices to create');
        }
    
        try {
            DB::table('devices')->insert($excel_devices);
            return redirect()->route('device.index')->with('success', 'Devices created successfully');
        } catch (Exception $e) {
            return redirect()->route('device.createExcelView')->with('error', $e->getMessage());
        }
    }
}
