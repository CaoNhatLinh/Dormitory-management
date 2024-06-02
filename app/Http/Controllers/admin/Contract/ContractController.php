<?php

namespace App\Http\Controllers\Admin\Contract;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Room;
use App\Models\RoomRental;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ContractController extends Controller
{
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
                        pageLength: 10,
                        lengthChange: true,
                        responsive: true,
                        info: false,
                        paging: true,
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
            if (!Session::has('user') && !Session::has('employee') && !Session::has('position_name')) {
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
            $contracts = Contract::all();

            $title = 'Contract List';


            $config = $this->config();
            $template = 'admin.contract.index';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'contracts',
                'title',
                'employee',
                'position_name',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function createView($id)
    {
        if (Auth::check()) {
            if (!Session::has('user') && !Session::has('employee') && !Session::has('position_name')) {
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
            DB::table('contracts')
                ->where('end_date', '<=', date('Y-m-d'))
                ->where('status', '=', 'renting')
                ->update(['status' => 'expired']);


            $config = $this->tailwindConfig();

            $student_id = $id;
            // Check if current student_id has contract and status = 'renting' then redirect to student detail page
            $contract = Contract::where('student_id', $student_id)->where('status', 'renting')->first();
            if ($contract) {
                return redirect()->route('student.detailView', ['id' => $student_id]);
            }

            $rooms = Room::all()->where('quantity', '<', 'occupancy');


            $title = 'Create contract';
            $template = 'admin.contract.create';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'student_id',
                'rooms',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function create(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $contract = new Contract();
        $contract->student_id = $id;
        $contract->room_id = $request->room_id;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        $contract->status = "renting";
        $contract->save();
        $roomRental = new RoomRental();
        $roomRental->room_id = $request->room_id;
        $roomRental->student_id = $id;
        $roomRental->status = 'unpaid';
        $roomRental->due_date = date('Y-m-d', strtotime($request->start_date . ' +1 month'));
        $roomRental->save();
        return redirect()->route('student.detailView', ['id' => $id]);
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

            DB::table('contracts')
                ->where('end_date', '<=', date('Y-m-d'))
                ->where('status', '=', 'renting')
                ->update(['status' => 'expired']);


            $config = $this->tailwindConfig();

            $contract = Contract::find($id);
            $rooms = Room::all()->where('quantity', '<', 'occupancy');

            $title = 'Edit contract';
            $template = 'admin.contract.edit';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'contract',
                'rooms',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function edit(Request $request, $id)
    {

        $contract = Contract::find($id);

        switch ($request->input('action')) {
            case 'edit':
                $contract->room_id = $request->room_id ?? $contract->room_id;
                $contract->save();
                $roomRental = RoomRental::where('student_id', $contract->student_id)->latest('due_date')->first();;
                if ($roomRental) {
                    $roomRental->room_id = $contract->room_id;
                    $roomRental->save();
                }

                break;

            case 'cancel':
                $contract->status = 'cancelled';
                $contract->save();
                break;

            default:
                break;
        }

        return redirect()->route('student.detailView', ['id' => $contract->student_id]);
    }
}
