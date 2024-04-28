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
    private function config()
    {
        return $config =[
            'js' =>[
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
                'js/plugins/chartJs/Chart.min.js',
                'js/plugins/toastr/toastr.min.js',

            ]
            ];
    }
    public function index()
    {
        $students = Student::all();

        $data = ['students' => $students];
        // return view('admin.student.index', $data);

        
        $config = $this->config();
        $template = 'admin.student.index';
        return view('admin.dashboard.layout',compact(
            'template','config','data'
        ));
    }
}
