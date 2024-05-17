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


class RoomController extends Controller
{
    const STATUSES  = ['active', 'inactive', 'repaired'];

    public function __construct()
    {
    }

    public function config()
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
        // Get all rooms with room type foreign key
        $rooms = Room::with('roomType')->get();
        $data = ['rooms' => $rooms];


        $id = Auth::id();
        $title = 'Room List';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.room.index';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'data',
            'title',
            'employee',
            'position_name'
        ));
    }

    public function createView()
    {
        $roomTypes = RoomType::all();

        $id = Auth::id();
        $title = 'Create Room';

        $employee = Employee::find($id);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
        $template = 'admin.room.create';
        $statuses = self::STATUSES;

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'roomTypes',
            'title',
            'employee',
            'position_name',
            'statuses'
        ));
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

        return redirect()->route('room.index');
    }

    public function editView($id)
    {
        $room = Room::find($id);
        $roomTypes = RoomType::all();

        $authId = Auth::id();
        $title = 'Update room';

        $employee = Employee::find($authId);
        $employee_id = $employee->employee_id;
        $position_name = Position::find($employee_id)->position_name;

        $config = $this->config();
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
            'statuses'
        ));
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

        return redirect()->route('room.index');
    }
}
