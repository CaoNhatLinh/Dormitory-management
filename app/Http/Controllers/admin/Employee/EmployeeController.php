<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function __construct()
    {
    }
    const STATUSES  = ['Working', 'Terminated', 'On Leave'];
    public function config()
    {




        return $config = [
            'js' => [
                'js/plugins/dataTables/datatables.min.js',
                'js/plugins/pace/pace.min.js',
                'js/plugins/footable/footable.all.min.js',
            ],
            'linkjs' => [],
            'css' => [
                'css/plugins/dataTables/datatables.min.css',
                'css/plugins/footable/footable.core.css',

            ],
            'linkcss' => [],

            'script' => [
                '
                $(document).ready(function(){
                    $(\'.dataTables-example\').DataTable({
                        pageLength: 10,
                        searching: true, 
                        ordering: true, 
                        responsive: true,
                        info: false,  
                        paging: true,
                        lengthChange: false,
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
    public function configCreateView()
    {

        return $config = [
            'js' => [

                'js/plugins/pace/pace.min.js',
                'js/plugins/datapicker/bootstrap-datepicker.js',
                'js/plugins/chosen/chosen.jquery.js',
                'js/plugins/jasny/jasny-bootstrap.min.js'
            ],
            'linkjs' => [
                'https://cdn.tailwindcss.com'
            ],
            'css' => [

                'css/plugins/datapicker/datepicker3.css',
                'css/plugins/chosen/bootstrap-chosen.css',
                'css/plugins/jasny/jasny-bootstrap.min.css',
                'css/profile.css'
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
                    })
                 ',
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
    public function configDetail()
    {
        return $config = [
            'js' => [
                'js/inspinia.js',

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

        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
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
            $title = 'Employeee list';
            $employees = Employee::with('position')->get();
            $data = ['employees' => $employees];
            $config = $this->config();
            $template = 'admin.employee.index';
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'position_name',
                'employee',
                'data','user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function createView()
    {
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
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
            $title = 'Create employee';

            $config = $this->configCreateView();
            $template = 'admin.employee.index';
            $positions = Position::all();
            $template = 'admin.employee.create';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'positions','user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'person_id' => 'required|integer|unique:employees',
            'name' => 'required|string',
            'avatar' => 'required|image|mimes:jpg,png,jpeg',
            'gender' => 'required|string',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'date_of_birth' => 'required|date',
            'position_id' => 'required|integer',
        ]);


        $image = $request->file('avatar');
        $imageName = time() . '.' . $image->getClientOriginalName();
        $path = public_path("/uploads/avatars");
        $image->move($path, $imageName);

        $avatar = $imageName;

        $employee = new Employee();
        $employee->person_id = $request->person_id;
        $employee->name = $request->name;
        $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_of_birth);
        $date = $dateTime->format('Y-m-d');

        $employee->date_of_birth = $date;
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->nationality = $request->nationality;
        $employee->position_id = $request->position_id;
        $employee->avatar = $avatar;
        $employee->status = "Working";

        $result = $employee->save();
        if ($result) {
            return redirect()->route('employee.index')->with('success', 'employee created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create employee.');
        }
    }
    public function detailView($id)
    {
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
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
            $title = 'Edit student';
            $config = $this->configDetail();
            $template = 'admin.employee.detail';
            $employeeDetails = Employee::with('position')->find($id);
            $statuses = self::STATUSES;
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'employeeDetails',
                'statuses','user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function editView($id)
    {
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
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
            $title = 'Edit employee';
            $config = $this->configCreateView();
            $template = 'admin.employee.edit';
            $statuses = self::STATUSES;
            $employeeEdit = Employee::find($id);
            $positions = Position::all();
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'employeeEdit',
                'positions',
                'statuses','user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function edit(Request $request, $id)
    {
        $employee = Employee::find($id);
        $request->validate([

            'name' => 'required|string',
            'avatar' => 'image|mimes:jpg,png,jpeg',
            'gender' => 'required|string',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'date_of_birth' => 'required|date',
            'position_id' => 'required|integer',
            'person_id' => [
                'required',
                Rule::unique('employees', 'person_id')->ignore($employee->person_id, 'person_id'),
            ],
            'status' => 'required|in:Working,Terminated,On Leave'

        ]);

        $employee->person_id = $request->person_id;
        $employee->name = $request->name;
        $employee->gender = $request->gender;
        $employee->nationality = $request->nationality;
        $employee->address = $request->address;
        $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_of_birth);
        $date = $dateTime->format('Y-m-d');
        $employee->date_of_birth = $date;
        $employee->position_id = $request->position_id;
        $employee->status = $request->status;
        if ($request->hasFile('avatar')) {
            $oldAvatarPath = public_path("/uploads/avatars/" . $employee->avatar);
            if (file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalName();
            $path = public_path("/uploads/avatars");
            $image->move($path, $imageName);
            $employee->avatar = $imageName;
        } else {
        }
        $result = $employee->save();

        if ($result) {
            return redirect()->route('employee.index')->with('success', 'employee edited successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update employee.');
        }
    }
}
