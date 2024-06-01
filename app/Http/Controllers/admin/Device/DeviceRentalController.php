<?php

namespace App\Http\Controllers\Admin\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\DeviceRental;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class DeviceRentalController extends Controller
{
    public function __construct()
    {
    }

    public function config()
    {
        return $config = [
            'js' => [
                'js/device.js',
                'js/devicerental.js',
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
                        lengthChange: false,
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
            $devices = Device::with('deviceType')->get();
            $data = ['devices' => $devices];
            $title = 'Device rental list';
            $config = $this->config();
            $template = 'admin.device.devicerental.index';

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
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }   
    public function getRooms()
    {
        $rooms = Room::all(['room_id', 'room_name']);
        return response()->json(['rooms' => $rooms]);
    }    
}