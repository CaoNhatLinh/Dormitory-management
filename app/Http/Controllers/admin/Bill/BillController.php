<?php

namespace App\Http\Controllers\Admin\Bill;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Position;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BillController extends Controller
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
                'js/plugins/steps/jquery.steps.min.js',
                'js/plugins/validate/jquery.validate.min.js'
                
            ],
            'linkjs' => [],
            'css' => [
                'css/plugins/iCheck/custom.css',
                'css/plugins/steps/jquery.steps.css',
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
            })
            ',
                '$(document).ready(function(){
                    $("#form").steps({
                        bodyTag: "fieldset",
                        onStepChanging: function (event, currentIndex, newIndex)
                        {
                            // Always allow going backward even if the current step contains invalid fields!
                            if (currentIndex > newIndex)
                            {
                                return true;
                            }
        
                            // Forbid suppressing "Warning" step if the user is to young
                            if (newIndex === 3 && Number($("#age").val()) < 18)
                            {
                                return false;
                            }
        
                            var form = $(this);
        
                            // Clean up if user went backward before
                            if (currentIndex < newIndex)
                            {
                                // To remove error styles
                                $(".body:eq(" + newIndex + ") label.error", form).remove();
                                $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                            }
        
                            // Disable validation on fields that are disabled or hidden.
                            form.validate().settings.ignore = ":disabled,:hidden";
        
                            // Start validation; Prevent going forward if false
                            return form.valid();
                        },
                        onStepChanged: function (event, currentIndex, priorIndex)
                        {
                            // Suppress (skip) "Warning" step if the user is old enough.
                            if (currentIndex === 2 && Number($("#age").val()) >= 18)
                            {
                                $(this).steps("next");
                            }
                            
                            if (currentIndex === 2 && priorIndex === 3)
                            {
                                $(this).steps("previous");
                            }
                        },
                        onFinishing: function (event, currentIndex)
                        {
                            var form = $(this);
                            
                            form.validate().settings.ignore = ":disabled";
        
                            // Start validation; Prevent form submission if false
                            return form.valid();
                        },
                        onFinished: function (event, currentIndex)
                        {
                            var form = $(this);
        
                            // Submit form input
                            form.submit();
                        }
                    }).validate({
                                errorPlacement: function (error, element)
                                {
                                    element.before(error);
                                },
                                rules: {
                                    confirm: {
                                        equalTo: "#password"
                                    }
                                }
                            });
               });'

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
            $title = 'Bill list';
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $template = 'admin.bill.index';
            $bills = Bill::with(['employee', 'room'])->get();
            $data = ['bills' => $bills];
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
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $title = 'Create invoice';
            $config = $this->configCreateView();
            $rooms = Room::all();
            $template = 'admin.bill.create';
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'rooms'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    // public function create(Request $request)
    // {
    //     $request->validate([
    //         'permission_name' => 'required|unique:permissions',

    //     ]);


    //     $permission = new Permission();
    //     $permission->permission_name = $request->permission_name;
    //     $result = $permission->save();

    //     if ($result) {
    //         return redirect()->route('permission.index')->with('success', 'permission created successfully.');
    //     } else {
    //         return redirect()->back()->with('error', 'Failed to create permission.');
    //     }
    // }


    // public function edit(Request $request)
    // {
    //     $request->validate([
    //         'permission_name' => 'required|unique:permissions'
    //     ]);

    //     $permission = Permission::find($request->permission_id);
    //     $permission->permission_name = $request->permission_name;
    //     $result = $permission->save();
    //     if ($result) {
    //         return redirect()->route('permission.index')->with('success', 'Permission edited successfully.');
    //     } else {
    //         return redirect()->back()->with('error', 'Failed to update Permission.');
    //     }
    // }
    // public function delete($id)
    // {
    //     $permission = Permission::find($id);

    //     if (!$permission) {
    //         return redirect()->route('permission.index')->with('error', 'Permission not found!');
    //     }

    //     $permission->delete();

    //     return redirect()->route('permission.index')->with('success', 'Permission deleted successfully!');
    // }
}
