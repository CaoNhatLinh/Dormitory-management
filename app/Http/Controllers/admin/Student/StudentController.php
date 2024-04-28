<?php

namespace App\Http\Controllers\Admin\Student;

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
        return view('admin.student.index', $data);
    }
}
