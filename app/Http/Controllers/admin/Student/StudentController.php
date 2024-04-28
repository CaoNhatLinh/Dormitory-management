<?php

namespace App\Http\Controllers\Admin\Student;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
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
