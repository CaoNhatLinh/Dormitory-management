<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
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
                'css/plugins/footable/footable.core.css'
            ],
            'linkcss' => [],

            'script' => [
                '$(document).ready(function() {

                    $(\'.footable\').footable();
        
                });',
                'document.addEventListener("DOMContentLoaded", function() {
                  
                    $(\'#myModal\').on(\'show.bs.modal\', function(event) {
                       
                        var button = $(event.relatedTarget);
                        var permissionId = button.data(\'id\');
                        var permissionName = button.data(\'name\');
                        
                        var modal = $(this);
                        modal.find(\'.modal-body input[name="permission_id"]\').val(permissionId);
                        modal.find(\'.modal-body input[name="permission_name"]\').val(permissionName);
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
            $title = 'Permission list';
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $template = 'admin.permission.index';
            
            $permissions = Permission::withCount('users')->get();
            $data = ['permissions' => $permissions];
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'position_name',
                'employee',
                'data',
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
                $employee = Employee::find($authId);
                $employee_id = $employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('position_name', $position_name);
            }
            $title = 'Create permission';
            $config = $this->configCreateView();
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $template = 'admin.permission.create';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',

            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|unique:permissions',

        ]);


        $permission = new Permission();
        $permission->permission_name = $request->permission_name;
        $result = $permission->save();

        if ($result) {
            return redirect()->route('permission.index')->with('success', 'permission created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create permission.');
        }
    }


    public function edit(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|unique:permissions'
        ]);

        $permission = Permission::find($request->permission_id);
        $permission->permission_name = $request->permission_name;
        $result = $permission->save();
        if ($result) {
            return redirect()->route('permission.index')->with('success', 'Permission edited successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update Permission.');
        }
    }
    public function delete($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return redirect()->route('permission.index')->with('error', 'Permission not found!');
        }

        $permission->delete();

        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully!');
    }
}
