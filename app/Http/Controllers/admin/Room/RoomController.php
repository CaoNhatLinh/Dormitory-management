<?php

namespace App\Http\Controllers\Admin\Room;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
    const STATUSES  = ['active', 'inactive', 'repaired'];

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
                'https://cdn.tailwindcss.com'
            ],
            'css' => [
                'css/plugins/dataTables/datatables.min.css',
                'css/plugins/footable/footable.core.css',
            ],
            'linkcss' => [],

            'script' => [
                '
                tailwind.config = {
                    prefix: \'tw-\',
                    corePlugins: {
                        preflight: false, // Set preflight to false to disable default styles
                    },
                }',
                '
                $(document).ready(function(){
                    $(\'.dataTables-example\').DataTable({
                        pageLength: 10,
                        lengthChange: true,
                        responsive: true,
                        info: false,
                        paging: true,
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
            ]
        ];
    }

    public function tailwindConfig()
    {
        return $config = [
            'js' => [],
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
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
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

            // Get all rooms with room type foreign key
            $rooms = Room::with('roomType')->get();
            $data = ['rooms' => $rooms];

            $title = 'Room List';

            $config = $this->config();
            $template = 'admin.room.index';

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'data',
                'title',
                'employee',
                'position_name',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function createView()
    {
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
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
            $roomTypes = RoomType::all();

            $title = 'Create Room';

            $config = $this->tailwindConfig();
            $template = 'admin.room.create';
            $statuses = self::STATUSES;

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'roomTypes',
                'title',
                'employee',
                'position_name',
                'statuses',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'room_name' => 'required|max:255|unique:rooms',
            'room_type_id' => 'required',
            'occupancy' => 'required|numeric|min:0|max:10',
            'quantity' => 'required|numeric|min:0|max:' . $request->occupancy,
            'status' => 'required|max:255',
        ]);

        $room = new Room();
        $room->room_name = $request->room_name;
        $room->room_type_id = $request->room_type_id;
        $room->occupancy = $request->occupancy;
        $room->quantity = $request->quantity;
        $room->status = $request->status ?? "active";
        $room->save();

        return redirect()->route('room.index')->with('success', 'Room created successfully');
    }

    public function editView($id)
    {
        if (Auth::check()) {
            if (!Session::has('user')|| !Session::has('employee') || !Session::has('position_name')) {
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

            $room = Room::find($id);
            $roomTypes = RoomType::all();


            $title = 'Update room';

            $config = $this->tailwindConfig();
            $template = 'admin.room.edit';

            $statuses = self::STATUSES;

            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'room',
                'roomTypes',
                'title',
                'employee',
                'position_name',
                'statuses','user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function edit(Request $request, $id)
    {
        $room = Room::find($id);


        $request->validate([
            'room_name' => [
                'required',
                Rule::unique('rooms', 'room_name')->ignore(trim($room->room_name), 'room_name'),
            ],
            'room_type_id' => 'required',
            'occupancy' => 'required|numeric|min:0|max:10',
            'quantity' => 'required|numeric|min:0|max:' . $request->occupancy,
            'status' => 'required|max:255',
        ]);

        $room->room_name = $request->room_name;
        $room->room_type_id = $request->room_type_id;
        $room->occupancy = $request->occupancy;
        $room->quantity = $request->quantity;
        $room->status = $request->status;
        $room->save();

        return redirect()->route('room.index')->with('success', 'Room updated successfully');
    }
}
