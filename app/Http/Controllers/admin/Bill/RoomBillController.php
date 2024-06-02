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
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    // public function createExcelViewConfig()
    // {
    //     return $config = [
    //         'js' => [
    //             'js/plugins/jqGrid/jquery.jqGrid.min.js',
    //             'js/plugins/jquery-ui/jquery-ui.min.js'
    //         ],
    //         'linkjs' => [
    //             'https://cdn.tailwindcss.com'
    //         ],
    //         'css' => [
    //             'css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css',
    //             'css/plugins/jqGrid/ui.jqgrid.css',
    //         ],
    //         'linkcss' => [],

    //         'script' => [
    //             '
    //             tailwind.config = {
    //                 prefix: \'tw-\',
    //                 corePlugins: {
    //                     preflight: false, // Set preflight to false to disable default styles
    //                 },
    //             }',

    //         ]
    //     ];
    // }

    public function index()
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
                'user',
                'roomBills',
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function createView()
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
                'user',
                'rooms'

            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
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

    public function loadExcel(Request $request)
    {
        $request->validate([
            'excel_room_bill' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        if ($request->hasFile('excel_room_bill')) {
            $file = $request->file('excel_room_bill');
            $fileName = 'excel_' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('/uploads/excels/');
            $file->move($path, $fileName);
            $filePath = 'uploads/excels/' . $fileName;

            return redirect()->route('bill.room.createExcelView', ['excel_file_path' => $filePath])->with('success', 'File uploaded successfully');
        } else {
            return redirect()->route('bill.room.createExcelView')->with('error', 'File not found');
        }
    }


    public function createExcelView(Request $request)
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
            $title = 'Create room bill by excel';


            $config = $this->config();
            $template = 'admin.bill.room.createExcel';


            $excel_room_bills = [];

            // EXCEL HANDLER
            // $excel_file_path = Session::get('excel_room_bill_path');
            $excel_file_path = $request->query('excel_file_path');
            $filePath = public_path($excel_file_path);

            // Check if file exists
            if (isset($excel_file_path) && file_exists($filePath)) {
                // Read excel file and return array data using phpoffice/phpspreadsheet
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();



                for ($row = 2; $row <= $highestRow; ++$row) {
                    // Skipping the header row
                    $bill_date_cell = $sheet->getCell('B' . $row)->getValue();
                    $bill_date = $bill_date_cell ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($bill_date_cell)->format('Y-m-d') : null;
                    $excel_room_bills[] = [
                        'room_id' => $sheet->getCell('A' . $row)->getValue(),
                        'bill_date' => $bill_date,
                        'electricity_price' => $sheet->getCell('C' . $row)->getValue(),
                        'electricity_index' => $sheet->getCell('D' . $row)->getValue(),
                        'water_price' => $sheet->getCell('E' . $row)->getValue(),
                        'water_index' => $sheet->getCell('F' . $row)->getValue(),
                        // 'total_room_bills' => $sheet->getCell('G' . $row)->getValue(),
                        // 'status' => $sheet->getCell('H' . $row)->getValue(),
                    ];
                }


                $json = json_encode($excel_room_bills);

                // dd($json);
                // CONFIG FOR JS
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
                                preflight: false, // Set preflight to false to disable default styles
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
                            colNames: [\'Room\', \'Date\', \'Electricity Price\', \'Electricity index\', \'Water price\', \'Water index \'],
                            colModel:  [
                                {name: \'room_id\', index: \'room_id\', width: 60},
                                {name: \'bill_date\', index: \'bill_date\', width: 90, sorttype: "string", formatter: "string"},
                                {name: \'electricity_price\', index: \'electricity_price\', width: 80},
                                {name: \'electricity_index\', index: \'electricity_index\', width: 80, align: "right"},
                                {name: \'water_price\', index: \'water_price\', width: 80, align: "right"},
                                {name: \'water_index\', index: \'water_index\', width: 80, align: "right"},

                            ],
                            pager: "#pager_list_1",
                            viewrecords: true,
                            caption: "Room bills",
                            hidegrid: false
                        });
                        $(window).bind(\'resize\', function () {
                            var width = $(\'.jqGrid_wrapper\').width();
                            $(\'#table_list_1\').setGridWidth(width);
                        });
                        '

                    ]
                ];
            }



            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'excel_room_bills',
                'excel_file_path',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function createExcel(Request $request)
    {

        // EXCEL HANDLER
        $excel_file_path = $request->excel_file_path;
        $filePath = public_path($excel_file_path);

        // Check if file exists
        if (!isset($excel_file_path) && !file_exists($filePath)) {
            return redirect()->route('bill.room.createExcelView')->with('error', 'File not found');
        }

        $excel_room_bills = [];

        // Retrieve existing room bills from the database
        $existingRoomBills = DB::table('room_bills')
            ->select('room_id', DB::raw('MAX(bill_date) as latest_bill_date'))
            ->groupBy('room_id')
            ->get()
            ->keyBy('room_id');


        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();


        for ($row = 2; $row <= $highestRow; ++$row) {

            $room_id = $sheet->getCell('A' . $row)->getValue();

            $bill_date_cell = $sheet->getCell('B' . $row)->getValue();
            $bill_date = $bill_date_cell ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($bill_date_cell)->format('Y-m-d') : null;

            $electricity_price = $sheet->getCell('C' . $row)->getValue();
            $electricity_index = $sheet->getCell('D' . $row)->getValue();
            $water_price = $sheet->getCell('E' . $row)->getValue();
            $water_index = $sheet->getCell('F' . $row)->getValue();


            $_electricity_price = $electricity_price / 1000;
            $_water_price = $water_price / 1000;
            $total_room_bills = ($_electricity_price * $electricity_index) + ($_water_price * $water_index);


            $latestBillDate = isset($existingRoomBills[$room_id]) ? $existingRoomBills[$room_id]->latest_bill_date : null;

            $betweenDate = $latestBillDate ? round((strtotime($bill_date) - strtotime($latestBillDate)) / (60 * 60 * 24)) : 0;

            if ((is_null($latestBillDate))) {
                $excel_room_bills[] = [
                    'room_id' => $room_id,
                    'bill_date' => $bill_date,
                    'electricity_price' => $electricity_price,
                    'electricity_index' => $electricity_index,
                    'water_price' => $water_price,
                    'water_index' => $water_index,
                    'total_room_bills' => $total_room_bills,
                    'status' => 'unpaid'
                ];
            } else if (!is_null($latestBillDate) && $betweenDate >= 30 && $betweenDate > 0) {
                $excel_room_bills[] = [
                    'room_id' => $room_id,
                    'bill_date' => $bill_date,
                    'electricity_price' => $electricity_price,
                    'electricity_index' => $electricity_index,
                    'water_price' => $water_price,
                    'water_index' => $water_index,
                    'total_room_bills' => $total_room_bills,
                    'status' => 'unpaid'
                ];
            } else {
                return redirect()->route('bill.room.createExcelView')->with('error', 'The bill date must be at least 30 days apart from the latest bill date');
            }
        }


        try {
            // Insert data into the room_bills table
            DB::table('room_bills')->insert($excel_room_bills);

            // remove the excel file in public folder
            unlink($filePath);

            return redirect()->route('bill.room.index')->with('success', 'Room bills created successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->route('bill.room.createExcelView')->with('error', $e->getMessage());
        }


        return redirect()->route('bill.room.createExcelView')->with('error', 'Room bills created failed');
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
                'statuses',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
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
