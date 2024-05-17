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
        // update contract status = 'expired' if end_date <= current date
        DB::table('contracts')
            ->where('end_date', '<=', date('Y-m-d'))
            ->update(['status' => 'expired']);
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

    public function editView($id)
    {
        $authId = Auth::id();
        $employee = Employee::find($authId);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;
        $config = $this->config();

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
            'rooms'
        ));
    }

    public function edit(Request $request, $id)
    {

        $contract = Contract::find($id);

        switch ($request->input('action')) {
            case 'edit':
                $contract->room_id = $request->room_id ?? $contract->room_id;
                $contract->save();
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
