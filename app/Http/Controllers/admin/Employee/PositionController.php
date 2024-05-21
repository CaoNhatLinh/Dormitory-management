<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PositionController extends Controller
{
    public function __construct()
    {
    }
    public function config()
    {




        return $config = [
            'js' => [

                'js/plugins/pace/pace.min.js',
                'js/plugins/footable/footable.all.min.js'

            ],
            'linkjs' => [],
            'css' => [
                // 'css/plugins/footable/footable.core.css'
            ],
            'linkcss' => [],

            'script' => [
                '$(document).ready(function() {

                    $(\'.footable\').footable();
                    $(\'.footable2\').footable();
        
                });',
                'document.addEventListener("DOMContentLoaded", function() {
                  
                    $(\'#myModal\').on(\'show.bs.modal\', function(event) {
                       
                        var button = $(event.relatedTarget);
                        var positionId = button.data(\'id\');
                        var positionName = button.data(\'name\');
                        
                        var modal = $(this);
                        modal.find(\'.modal-body input[name="position_id"]\').val(positionId);
                        modal.find(\'.modal-body input[name="position_name"]\').val(positionName);
                    });
                });'
            ]


        ];
    }
    public function configCreateView()
    {

        return $config = [
            'js' => [

                'js/plugins/pace/pace.min.js',
                'js/plugins/datapicker/bootstrap-datepicker.js',
                'js/plugins/chosen/chosen.jquery.js',
            ],
            'linkjs' => [],
            'css' => [

                'css/plugins/datapicker/datepicker3.css',
                'css/plugins/chosen/bootstrap-chosen.css'
            ],
            'linkcss' => [],

            'script' => [

                ' $(document).ready(function(){

                $(\'#data_1 .input-group.date\').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });
                $(\'.chosen-select\').chosen({ width: "100%" });
            
            })',
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
            $config = $this->config();
            $title = 'Position list';
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $template = 'admin.position.index';
            
            $positions = Position::withCount('employees')->get();
            $data = ['positions' => $positions];
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'position_name',
                'employee',
                'data',
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
            $title = 'Create position';
            $config = $this->configCreateView();
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $template = 'admin.position.create';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',

            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'position_name' => 'required|unique:positions',

        ]);


        $position = new Position();
        $position->position_name = $request->position_name;
        $result = $position->save();

        if ($result) {
            return redirect()->route('position.index')->with('success', 'position created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create position.');
        }
    }


    public function edit(Request $request)
    {
        $request->validate([
            'position_name' => 'required|unique:positions'
        ]);

        $position = Position::find($request->position_id);
        $position->position_name = $request->position_name;
        $result = $position->save();
        if ($result) {
            return redirect()->route('position.index')->with('success', 'position edited successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update position.');
        }
    }
}
