<?php

namespace App\Http\Controllers\Admin\Room;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class RoomTypeController extends Controller
{
    public function __construct()
    {
    }

    public function config()
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
            $roomTypes = RoomType::all();
            $data = ['roomTypes' => $roomTypes];
            $title = 'Room type list';

            $config = $this->config();
            $template = 'admin.room.type.index';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'data',
                'title',
                'employee',
                'position_name'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }

    public function createView()
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

            $title = 'Create room type';
            $config = $this->config();

            $template = 'admin.room.type.create';


            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'room_type_name' => 'required|unique:room_types',
            'room_type_price' => 'required|numeric',
        ]);

        $roomType = new RoomType();
        $roomType->room_type_name = $request->room_type_name;
        $roomType->room_type_price = $request->room_type_price;
        $roomType->save();

        return redirect()->route('roomType.index')->with('success', 'Room type created successfully');
    }

    public function editView($id)
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

            $title = 'Edit room type';
            $config = $this->config();

            $template = 'admin.room.type.edit';

            $roomType = RoomType::find($id);

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'roomType'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'vui lòng đăng nhập');
        }
    }

    public function edit(Request $request, $id)
    {
        $roomType = RoomType::find($id);

        // Validate
        $request->validate([
            'room_type_name' => [
                'required',
                Rule::unique('room_types', 'room_type_name')->ignore($roomType->room_type_name, 'room_type_name'),
            ],
            'room_type_price' => 'required|numeric',
        ]);

        // Update
        $roomType->room_type_name = $request->room_type_name;
        $roomType->room_type_price = $request->room_type_price;
        $result = $roomType->save();

        return redirect()->route('roomType.index')->with('success', 'Room type updated successfully');
    }
}
