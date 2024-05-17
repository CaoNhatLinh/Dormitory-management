<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
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
                            { extend: \'copy\'},
                            {extend: \'csv\'},
                            {extend: \'excel\', title: \'ExampleFile\'},
                            {extend: \'pdf\', title: \'ExampleFile\'},
        
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
        
        if (Auth::check()) {
            $config = $this->config();
            $title = 'Dormitory management';
            $employees = Employee::all();
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
  
}
