<?php

namespace App\Http\Controllers\Admin\Contract;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                
                'js/jquery-3.1.1.min.js',
                'js/bootstrap.min.js',
                'js/plugins/metisMenu/jquery.metisMenu.js',
                'js/plugins/slimscroll/jquery.slimscroll.min.js',
                'js/plugins/dataTables/datatables.min.js',
                'js/inspinia.js',
                'js/plugins/pace/pace.min.js',
            ],
            'linkjs' => [
                'https://cdn.tailwindcss.com'
            ],
            'css' => [],
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
        $contracts = Contract::all();
        $data = ['contracts' => $contracts];
        $id = Auth::id();
        $title = 'Contract List';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.contract.index';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'data',
            'title',
            'employee',
            'position_name'
        ));
    }

    public function createView($id)
    {
        $authId = Auth::id();
        $employee = Employee::find($authId);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;
        $config = $this->config();

        $student_id = $id;
        // Get rooms with quantity less than occupancy
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
            'rooms'
        ));
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
        $contract->status = "active";
        $contract->save();


        return redirect()->route('student.detailView', ['id' => $id]);
    }
}
