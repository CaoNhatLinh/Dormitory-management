<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {

        $config = $this->config();
        $title = 'Dormitory management';
        $id = Auth::id();
        $title = 'Student';
        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id) -> position_name;
        $template = 'admin.dashboard.home.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'title','position_name','employee'
        ));
    }
}
