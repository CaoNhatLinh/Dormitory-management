<?php

namespace App\Http\Controllers\Admin\Student;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
    }
    public function config()
    {
        return $config = [
            'js' => [
                'js/plugins/flot/jquery.flot.js',
                'js/plugins/flot/jquery.flot.js',
                'js/plugins/flot/jquery.flot.tooltip.min.js',
                'js/plugins/flot/jquery.flot.spline.js',
                'js/plugins/flot/query.flot.resize.js',
                'js/plugins/flot/query.flot.resize.js',
                'js/plugins/flot/jquery.flot.pie.js',
                'js/plugins/peity/jquery.peity.min.js',
                'js/demo/peity-demo.js',
                'js/inspinia.js',
                'js/plugins/gritter/jquery.gritter.min.js',
                'js/demo/sparkline-demo.js',
                'js/plugins/sparkline/jquery.sparkline.min.js',
                'js/plugins/toastr/toastr.min.js',

            ],
            'css' => []
        ];
    }
    public function index()
    {
        $students = Student::all();
        $data = ['students' => $students];
        $id = Auth::id();
        $title = 'Student';
        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id) -> position_name;
        $config = $this->config();
        $template = 'admin.student.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'data',
            'title',
            'employee',
            'position_name'
        ));
    }
}
