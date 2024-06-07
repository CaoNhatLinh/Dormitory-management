<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Contract;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Room;
use App\Models\RoomRental;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                'js/plugins/dataTables/datatables.min.js',
                'js/plugins/pace/pace.min.js',
                'js/plugins/footable/footable.all.min.js',
                'js/plugins/flot/jquery.flot.js',
                'js/plugins/flot/jquery.flot.tooltip.min.js',
                'js/plugins/flot/jquery.flot.spline.js',
                'js/plugins/flot/jquery.flot.resize.js',
                'js/plugins/flot/jquery.flot.pie.js',
                'js/plugins/flot/jquery.flot.symbol.js',
                'js/plugins/flot/jquery.flot.time.js',
                'js/plugins/easypiechart/jquery.easypiechart.js'
            ],
            'linkjs' => [],
            'css' => [
                'css/plugins/dataTables/datatables.min.css',
                'css/plugins/footable/footable.core.css',
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
                            {extend: \'excel\', title: \'ExampleFile\'},
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
                $(document).ready(function () {
                    var currentYear = new Date().getFullYear();
                    function gd(year, month, day) {
                        return new Date(year, month - 1, day).getTime();
                    }
                    function plotData(data3, data2) {
                        var dataset = [
                            {
                                label: "Total Bill",
                                data: data3,
                                color: "#1ab394",
                                bars: {
                                    show: true,
                                    align: "center",
                                    barWidth: 60 * 600 * 60 * 600,
                                    lineWidth: 0
                                }
                            },
                            {
                                label: "Bill Count",
                                data: data2,
                                yaxis: 2,
                                color: "#1C84C6",
                                lines: {
                                    lineWidth: 1,
                                    show: true,
                                    fill: true,
                                    fillColor: {
                                        colors: [{ opacity: 0.2 }, { opacity: 0.4 }]
                                    }
                                },
                                splines: {
                                    show: false,
                                    tension: 0.6,
                                    lineWidth: 1,
                                    fill: 0.1
                                }
                            }
                        ];
                        var options = {
                            xaxis: {
                                mode: "time",
                                tickSize: [1, "month"],
                                tickLength: 0,
                                axisLabel: "Date",
                                axisLabelUseCanvas: true,
                                axisLabelFontSizePixels: 12,
                                axisLabelFontFamily: \'Arial\',
                                axisLabelPadding: 10,
                                color: "#d5d5d5"
                            },
                            yaxes: [{
                                position: "left",
                                color: "#d5d5d5",
                                axisLabelUseCanvas: true,
                                axisLabelFontSizePixels: 12,
                                axisLabelFontFamily: \'Arial\',
                                axisLabelPadding: 3
                            }, {
                                position: "right",
                                color: "#d5d5d5",
                                axisLabelUseCanvas: true,
                                axisLabelFontSizePixels: 12,
                                axisLabelFontFamily: \'Arial\',
                                axisLabelPadding: 67
                            }],
                            legend: {
                                noColumns: 1,
                                labelBoxBorderColor: "#000000",
                                position: "nw"
                            },
                            grid: {
                                hoverable: false,
                                borderWidth: 0
                            }
                        };
        
                        $.plot($("#flot-dashboard-chart"), dataset, options);
                    }
                    $.ajax({
                        url: \'/dormitory-management/public/bill-Total/\' + currentYear,
                        method: \'GET\',
                        success: function(response3) {
                            var data3 = response3.map(function(item) {
                                var year = item[0][0];
                                var month = item[0][1];
                                var total = item[1];
                                return [gd(year, month, 1), total];
                            });
        
                            $.ajax({
                                url: \'/dormitory-management/public/bill-Cout/\' + currentYear,
                                method: \'GET\',
                                success: function(response2) {
                                    var data2 = response2.map(function(item) {
                                        var year = item[0][0];
                                        var month = item[0][1];
                                        var total = item[1];
                                        return [gd(year, month, 1), total];
                                    });
        
                                    plotData(data3, data2);
                                },
                                error: function(xhr, status, error) {
                                    console.error(\'Error fetching data2:\', error);
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(\'Error fetching data3:\', error);
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
            if (!Session::has('user') && !Session::has('employee') && !Session::has('position_name')) {
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
            $title = 'Dormitory management';
            $totalContracts = Contract::where('status', 'renting')
                ->where('end_date', '>', Carbon::now())
                ->count();
            $totalRooms = Room::count();
            $totalDevices = Device::count();
            $totalStudents = Student::count();
            $totalEmployees = Employee::where('status', 'Working')->count();

            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $totalBills = Bill::whereYear('date_bill', $currentYear)
                ->whereMonth('date_bill', $currentMonth)
                ->sum('total_bill');
            $fifteenDaysAgo = Carbon::now()->addDays(15)->toDateString();
            $listStudentNotPaid = RoomRental::where('status', 'unpaid')
                ->whereDate('due_date', '<=', $fifteenDaysAgo)
                ->with(['student', 'room' => function ($query) {
                    $query->select('room_id', 'room_name', 'room_type_id');
                }, 'room.roomType' => function ($query) {
                    $query->select('room_type_id', 'room_type_name', 'room_type_price');
                }])
                ->get();
            $config = $this->config();
            $template = 'admin.dashboard.home.index';
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'position_name',
                'employee',
                'user',
                'totalStudents',
                'totalRooms',
                'totalContracts',
                'totalBills',
                'totalDevices',
                'totalEmployees',
                'listStudentNotPaid',
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function getMonthlyBillStatistics($year)
    {
        $bills = Bill::select(
            DB::raw('YEAR(date_bill) as year'),
            DB::raw('MONTH(date_bill) as month'),
            DB::raw('SUM(total_bill) as total_bill')
        )
            ->whereYear('date_bill', $year)
            ->groupBy(DB::raw('YEAR(date_bill)'), DB::raw('MONTH(date_bill)'))
            ->get();

        $monthlyStatistics = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyStatistics[] = [[$year, $month], 0];
        }
        foreach ($bills as $bill) {
            $monthlyStatistics[$bill->month - 1] = [[$bill->year, $bill->month], $bill->total_bill];
        }

        return response()->json($monthlyStatistics);
    }
    public function getBillStatistics($year)
    {
        $bills = DB::table('bills')
            ->select(
                DB::raw('YEAR(date_bill) as year'),
                DB::raw('MONTH(date_bill) as month'),
                DB::raw('COUNT(bill_id) as bill_count')
            )
            ->whereYear('date_bill', $year)
            ->groupBy('year', 'month')
            ->get();
        $billStatistics = [];
        for ($month = 1; $month <= 12; $month++) {
            $found = false;
            foreach ($bills as $bill) {
                if ($bill->month == $month) {
                    $billStatistics[] = [[$year, $month], $bill->bill_count];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $billStatistics[] = [[$year, $month], 0];
            }
        }

        return response()->json($billStatistics);
    }
}
