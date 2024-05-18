<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
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
               
            ],
            'css' => [
                'css/plugins/dataTables/datatables.min.css',
                'css/plugins/footable/footable.core.css',
                
            ],
            'linkcss' => [
                
            ],
            
            'script' => [
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
    public function configCreateView()
    {

    return $config = [
        'js' => [
            
            'js/plugins/pace/pace.min.js',
            'js/plugins/datapicker/bootstrap-datepicker.js',
            'js/plugins/chosen/chosen.jquery.js', 
        ],
        'linkjs' => [
           
        ],
        'css' => [
            
            'css/plugins/datapicker/datepicker3.css',
            'css/plugins/chosen/bootstrap-chosen.css'
        ],
        'linkcss' => [
            
        ],
        
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
public function configDetail()
    {
        return $config = [
            'js' => [
                'js/inspinia.js',

            ],
            'linkjs' => [
                'https://cdn.tailwindcss.com'
            ],
            'css' => [
                
            ],
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
        
        if (Auth::check()) {
            $config = $this->config();
            $title = 'Employeee list';
            $employees = Employee::with('position')->get();
            $data = ['employees' => $employees];
            $id = Auth::id();
            $employee = Employee::find($id);
            $employee_id = $employee->employee_id;
            $position_name = Position::find($employee_id)->position_name;
            $template = 'admin.employee.index';
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
        $id = Auth::id();
        $title = 'Create employee';
        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;
        $config = $this->configCreateView();

        $positions = Position::all();
        $template = 'admin.employee.create';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name',
            'positions',
        ));
    }

    public function create(Request $request)
    {
        $request->validate([
            'person_id' => 'required|unique:employees',
            'name' => 'required',
            'avatar' => 'required|image|mimes:jpg,png,jpeg',
            'gender' => 'required',
            'address' => 'required',
            'nationality' => 'required',
            'date_of_birth' => 'required|date',
            'position_id' => 'required',
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
        $employee->status = "working";

        $result = $employee->save();
        if ($result) {
            return redirect()->route('employee.index')->with('success', 'employee created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create employee.');
        }
    }
    public function detailView($id)
    {
        // Config - template
        $authId = Auth::id();
        $title = 'Edit student';
        $employee = Employee::find($authId);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;
        $config = $this->configDetail();
        $template = 'admin.employee.detail';


        // Data 
        $employeeDetails = Employee::with('position')->find($id);

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name',
            'employeeDetails'
        ));
    }
    public function editView($id)
    {
        // Config - template
        $authId = Auth::id();
        $title = 'Edit employee';
        $employee = Employee::find($authId);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;
        $config = $this->configCreateView(); 
        $template = 'admin.employee.edit';
        

        // Data 
        $employee = Employee::find($id);
        $positions = Position::all();
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title',
            'employee',
            'position_name',
            'employee',
            'positions'
        ));
    }

    public function edit(Request $request, $id)
    {
        $employee = Employee::find($id);

        $request->validate([
            'name' => 'required',
            'nationality' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'position_id' => 'required',
            'nationality' => 'required',
            'person_id' => [
                'required',
                Rule::unique('employee', 'person_id')->ignore($employee->person_id, 'person_id'),
            ]
            
        ]);


        $employee->name = $request->name;
        $employee->date_of_birth = $request->date_of_birth;
        $employee->gender = $request->gender;
        $employee->nationality = $request->nationality;
        $employee->person_id = $request->person_id;
        $employee->position_id = $request->position_id;
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
