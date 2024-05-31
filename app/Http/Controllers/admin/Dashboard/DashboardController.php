<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
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
                'js/plugins/gritter/jquery.gritter.min.js',
                'js/demo/sparkline-demo.js',
                'js/plugins/sparkline/jquery.sparkline.min.js',
                'js/plugins/chartJs/Chart.min.js',
                'js/plugins/toastr/toastr.min.js',
                'js/plugins/d3/d3.min.js',
                'js/plugins/c3/c3.min.js',

            ],
            'linkjs' => [],
            'css' => [
                'css/dashboard.css'
            ],
            'linkcss' => [],
            'script' => [
                '
                $(document).ready(function() {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: \'slideDown\',
                            timeOut: 4000
                        };
                        toastr.success(\'domitory management system\', \'Welcome\');
        
                    }, 1300);
                });
                ',
                '
                $(document).ready(function () { 

                    c3.generate({
                        bindto: \'#lineChart\',
                        data:{
                            columns: [
                                [\'data1\', 30, 200, 100, 400, 150, 250],
                                [\'data2\', 50, 20, 10, 40, 15, 25]
                            ],
                            colors:{
                                data1: \'#1ab394\',
                                data2: \'#BABABA\'
                            }
                        }
                    });
        
                    c3.generate({
                        bindto: \'#slineChart\',
                        data:{
                            columns: [
                                [\'data1\', 30, 200, 100, 400, 150, 250],
                                [\'data2\', 130, 100, 140, 200, 150, 50]
                            ],
                            colors:{
                                data1: \'#1ab394\',
                                data2: \'#BABABA\'
                            },
                            type: \'spline\'
                        }
                    });
        
                    c3.generate({
                        bindto: \'#scatter\',
                        data:{
                            xs:{
                                data1: \'data1_x\',
                                data2: \'data2_x\'
                            },
                            columns: [
                                ["data1_x", 3.2, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2.0, 3.0, 2.2, 2.9, 2.9, 3.1, 3.0, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3.0, 2.8, 3.0, 2.9, 2.6, 2.4, 2.4, 2.7, 2.7, 3.0, 3.4, 3.1, 2.3, 3.0, 2.5, 2.6, 3.0, 2.6, 2.3, 2.7, 3.0, 2.9, 2.9, 2.5, 2.8],
                                ["data2_x", 3.3, 2.7, 3.0, 2.9, 3.0, 3.0, 2.5, 2.9, 2.5, 3.6, 3.2, 2.7, 3.0, 2.5, 2.8, 3.2, 3.0, 3.8, 2.6, 2.2, 3.2, 2.8, 2.8, 2.7, 3.3, 3.2, 2.8, 3.0, 2.8, 3.0, 2.8, 3.8, 2.8, 2.8, 2.6, 3.0, 3.4, 3.1, 3.0, 3.1, 3.1, 3.1, 2.7, 3.2, 3.3, 3.0, 2.5, 3.0, 3.4, 3.0],
                                ["data1", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
                                ["data2", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8]
                            ],
                            colors:{
                                data1: \'#1ab394\',
                                data2: \'#BABABA\'
                            },
                            type: \'scatter\'
                        }
                    });
        
                    c3.generate({
                        bindto: \'#stocked\',
                        data:{
                            columns: [
                                [\'data1\', 30,200,100,400,150,250],
                                [\'data2\', 50,20,10,40,15,25]
                            ],
                            colors:{
                                data1: \'#1ab394\',
                                data2: \'#BABABA\'
                            },
                            type: \'bar\',
                            groups: [
                                [\'data1\', \'data2\']
                            ]
                        }
                    });
        
                    c3.generate({
                        bindto: \'#gauge\',
                        data:{
                            columns: [
                                [\'data\', 91.4]
                            ],
        
                            type: \'gauge\'
                        },
                        color:{
                            pattern: [\'#1ab394\', \'#BABABA\']
        
                        }
                    });
        
                    c3.generate({
                        bindto: \'#pie\',
                        data:{
                            columns: [
                                [\'data1\', 30],
                                [\'data2\', 120]
                            ],
                            colors:{
                                data1: \'#1ab394\',
                                data2: \'#BABABA\'
                            },
                            type : \'pie\'
                        }
                    });
        
                });
                '
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
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $title = 'Dormitory management';
            $config = $this->config();
            $template = 'admin.dashboard.home.index';
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'position_name',
                'employee'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
}
