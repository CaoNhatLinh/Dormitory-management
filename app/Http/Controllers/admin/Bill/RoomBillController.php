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

class RoomBillController extends Controller
{

    const STATUSES  = ['paid' => 'Đã thanh toán', 'unpaid' => 'Chưa thanh toán'];

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

    public function index()
    {
        $id = Auth::id();
        $title = 'Room bill';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.bill.room.index';

        // Get all room bill from database order by bill_date
        $roomBills = RoomBill::all();
        $statuses = self::STATUSES;

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name',
            'roomBills',
            'statuses'
        ));
    }

    public function createView()
    {
        $id = Auth::id();
        $title = 'Create room bill';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.bill.room.create';

        $statuses = self::STATUSES;
        $rooms = Room::all();

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name',
            'statuses',
            'rooms'

        ));
    }

    public function create(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'electricity_price' => 'required|numeric',
            'water_price' => 'required|numeric',
            'status' => 'required|string|max:255',
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
        $roomBill->status = $request->status;
        $roomBill->water_index = $request->water_index;
        $roomBill->electricity_index = $request->electricity_index;
        $roomBill->total_room_bills = ($_electricity_price * $request->electricity_index) + ($_water_price * $request->water_index);
        $result = $roomBill->save();


        if ($result) return redirect()->route('bill.room.index')->with('success', 'Room bill created successfully.');
        else return redirect()->route('bill.room.index')->with('error', 'Room bill created failed.');
    }

    public function createExcelView(Request $request)
    {
        $id = Auth::id();
        $title = 'Create room bill by excel';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.bill.room.createExcel';



        $excel_room_bills = [];

        // if ($request->hasFile('excel_room_bill')) {
        //     $excel_room_bills = Excel::toArray(new RoomBillsImport, $request->file('excel_room_bill'));
        //     $excel_room_bills = $excel_room_bills[0]; // Lấy sheet đầu tiên
        // }


        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name',
            'excel_room_bills'
        ));
    }

    public function createExcel(Request $request)
    {

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
        $id = Auth::id();
        $title = 'Edit room bill';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.bill.room.edit';

        $statuses = self::STATUSES;
        $rooms = Room::all();
        $roomBill = RoomBill::find($id);

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name',
            'statuses',
            'rooms',
            'roomBill'
        ));
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
