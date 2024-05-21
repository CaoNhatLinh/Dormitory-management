<?php

namespace App\Http\Controllers\Admin\Bill;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Imports\RoomBillsImport;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Room;
use App\Models\RoomBill;
use App\Models\RoomType;
use Illuminate\Support\Facades\Session;

class RoomBillController extends Controller
{

    const STATUSES = ['paid', 'unpaid'];

    public function __construct()
    {
    }

    public function config()
    {
        return $config = [
            'js' => [
                'js/plugins/dataTables/datatables.min.js',
                'js/plugins/pace/pace.min.js',
                'js/plugins/footable/footable.all.min.js',
            ],
            'linkjs' => [
                'https://cdn.tailwindcss.com'
            ],
            'css' => [
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
                    $(\'.dataTables-example\').DataTable({
                        pageLength: 25,
                        responsive: true,
                        dom: \'<"html5buttons"B>lTfgitp\',
                        buttons: [
        
                            {extend: \'print\',
                             customize: function (win){
                                    $(win.document.body).addClass(\'white-bg\');
                                    $(win.document.body).css(\'font-size\', \'10px\');
        
                                    $(win.document.body).find(\'table\')
                                            .addClass(\'compact\')
                                            .css(\'font-size\', \'inherit\');
                            }
                            }
                        ]
        
                    });
        
                });
                ',
                '
                $(document).ready(function() {
        
                    $(\'.footable\').footable();
                    $(\'.footable2\').footable();
        
                });
                '
            ]
        ];
    }

    public function tailwindConfig()
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

            $title = 'Room bill';

            $config = $this->config();
            $template = 'admin.bill.room.index';

            // Get all room bill from database order by bill_date
            $roomBills = RoomBill::all();

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'roomBills',
            ));
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
            $title = 'Create room bill';


            $config = $this->tailwindConfig();
            $template = 'admin.bill.room.create';

            $rooms = Room::all();

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'rooms'

            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'electricity_price' => 'required|numeric',
            'water_price' => 'required|numeric',
            'water_index' => 'required|numeric',
            'electricity_index' => 'required|numeric',
        ]);

        $roomBill = new RoomBill();
        $roomBill->room_id = $request->room_id;
        $roomBill->bill_date = date('Y-m-d');
        $_electricity_price = $request->electricity_price / 1000;
        $_water_price = $request->water_price / 1000;

        $roomBill->electricity_price = $request->electricity_price;
        $roomBill->water_price = $request->water_price;
        $roomBill->status = "unpaid";
        $roomBill->water_index = $request->water_index;
        $roomBill->electricity_index = $request->electricity_index;
        $roomBill->total_room_bills = ($_electricity_price * $request->electricity_index) + ($_water_price * $request->water_index);
        $result = $roomBill->save();


        if ($result) return redirect()->route('bill.room.index')->with('success', 'Room bill created successfully.');
        else return redirect()->route('bill.room.index')->with('error', 'Room bill created failed.');
    }

    public function createExcelView(Request $request)
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
            $title = 'Create room bill by excel';


            $config = $this->config();
            $template = 'admin.bill.room.createExcel';

            $excel_room_bills = [];
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'excel_room_bills'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }

    public function createExcel(Request $request)
    {
        if (Session::has('employee') && Session::has('position_name')) {
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
        }

        return redirect()->route('bill.room.index');
    }

    public function loadExcel(Request $request)
    {
        $request->validate([
            'excel_room_bill' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        return redirect()->route('bill.room.createExcelView')->with('excel_room_bill', $request->file('excel_room_bill'));
    }

    public function editView($id)
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

            $title = 'Edit room bill';

            $config = $this->tailwindConfig();
            $template = 'admin.bill.room.edit';

            $rooms = Room::all();
            $roomBill = RoomBill::find($id);
            $statuses = self::STATUSES;

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'rooms',
                'roomBill',
                'statuses'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'electricity_price' => 'required|numeric',
            'water_price' => 'required|numeric',
            'status' => 'required|string|max:255',
            'water_index' => 'required|numeric',
            'electricity_index' => 'required|numeric',
        ]);

        $roomBill = RoomBill::find($id);
        $roomBill->room_id = $request->room_id;
        $roomBill->bill_date = date('Y-m-d');
        $_electricity_price = $request->electricity_price / 1000;
        $_water_price = $request->water_price / 1000;

        $roomBill->electricity_price = $request->electricity_price;
        $roomBill->water_price = $request->water_price;
        $roomBill->status = $request->status;
        $roomBill->water_index = $request->water_index;
        $roomBill->electricity_index = $request->electricity_index;
        $roomBill->total_room_bills = ($_electricity_price * $request->electricity_index) + ($_water_price * $request->water_index);
        $result = $roomBill->save();

        if ($result) return redirect()->route('bill.room.index')->with('success', 'Room bill updated successfully.');
        else return redirect()->route('bill.room.index')->with('error', 'Room bill updated failed.');
    }
}
