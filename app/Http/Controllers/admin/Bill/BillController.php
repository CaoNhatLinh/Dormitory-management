<?php

namespace App\Http\Controllers\Admin\Bill;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Contract;
use App\Models\DeviceRental;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Position;
use App\Models\DeviceRentalDetail;
use App\Models\Room;
use App\Models\RoomBill;
use App\Models\RoomRental;
use App\Models\RoomType;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class BillController extends Controller
{
    public function __construct()
    {
    }
    public function config()
    {

        return $config = [
            'js' => [

                'js/plugins/pace/pace.min.js',
                'js/plugins/footable/footable.all.min.js'

            ],
            'linkjs' => [],
            'css' => [
                'css/plugins/footable/footable.core.css'
            ],
            'linkcss' => [],

            'script' => [
                '$(document).ready(function() {

                    $(\'.footable\').footable();
        
                });',
                'document.addEventListener("DOMContentLoaded", function() {
                  
                    $(\'#myModal\').on(\'show.bs.modal\', function(event) {
                       
                        var button = $(event.relatedTarget);
                        var permissionId = button.data(\'id\');
                        var permissionName = button.data(\'name\');
                        
                        var modal = $(this);
                        modal.find(\'.modal-body input[name="permission_id"]\').val(permissionId);
                        modal.find(\'.modal-body input[name="permission_name"]\').val(permissionName);
                    });
                });'
            ]


        ];
    }
    public function configCreateView()
    {

        return $config = [
            'js' => [

                'js/plugins/pace/pace.min.js',
                'js/plugins/steps/jquery.steps.min.js',
                'js/plugins/validate/jquery.validate.min.js'

            ],
            'linkjs' => [],
            'css' => [
                'css/plugins/iCheck/custom.css',
                'css/plugins/steps/jquery.steps.css',
            ],
            'linkcss' => [],

            'script' => [
                '
            function initializePage() {
                function fetchStudents(roomId) {
                    $.ajax({
                        url: \'/dormitory-management/public/api/student/\' + roomId, 
                        method: \'GET\',
                        data: {
                            room_id: roomId
                        },
                        success: function(data){
                            $(\'#studentDropdownContainer\').show();
                            $(\'select[name="student_id"]\').html(data);
                            $(\'#studentErrorBlock\').text(\'\');
                        },
                        error: function(xhr, status, error){
                            console.error(error);
                            $(\'#studentDropdownContainer\').hide(); 
                            $(\'#studentErrorBlock\').text(\'Error occurred while fetching students.\'); 
                        }
                    });
                }
                var selectedType = $(\'select[name="typePayment"]\').val();
                if(selectedType == \'billroom\'){
                    var roomId = $(\'select[name="room_id"]\').val();
                    fetchStudents(roomId);
                }
                $(\'select[name="typePayment"]\').change(function(){
                    var selectedType = $(this).val();
                    if(selectedType == \'billroom\'){
                        var roomId = $(\'select[name="room_id"]\').val();
                        fetchStudents(roomId);
                    } else {
                        $(\'#studentDropdownContainer\').hide(); 
                        $(\'select[name="student_id"]\').html(\'\'); 
                        $(\'#studentErrorBlock\').text(\'\'); 
                    }
                });
                $(\'select[name="room_id"]\').change(function(){
                    var selectedType = $(\'select[name="typePayment"]\').val();
                    if(selectedType == \'billroom\'){
                        var roomId = $(this).val();
                        fetchStudents(roomId);
                    }
                });
            }
            $(document).ready(function(){
                initializePage();
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
                $user = User::find($authId)->with('employee');
                $employee =Employee::find($user->employee_id);
                $employee_id = $user->employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $config = $this->config();
            $title = 'Bill list';
            $template = 'admin.bill.index';
            $bills = Bill::with(['employee', 'room'])->get();
            $data = ['bills' => $bills];
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'position_name',
                'employee',
                'user',
                'data',
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function createView()
    {
        if (Auth::check()) {
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId)->with('employee');
                $employee =Employee::find($user->employee_id);
                $employee_id = $user->employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $title = 'Select invoice';
            $config = $this->configCreateView();
            $rooms = Room::all();
            $template = 'admin.bill.create';
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'rooms',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'typePayment' => 'required|in:billroom,EaW,equipment'
        ]);
        $room_id = $request->room_id;
        $student_id = $request->has('student_id') ? $request->student_id : null;
        $typePayment = $request->typePayment;
        if ($typePayment == 'billroom')
            return redirect()->route('bill.billroomView', ['id' => $room_id, 'student_id' => $student_id]);
        else if ($typePayment == 'EaW') return redirect()->route('bill.eawView', $room_id);
        else  return redirect()->route('bill.equipmentView', $room_id);
    }
    public function billroomView($id, $student_id)
    {
        if (Auth::check()) {
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId)->with('employee');
                $employee =Employee::find($user->employee_id);
                $employee_id = $user->employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $title = 'room invoice';
            $config = $this->configCreateView();
            $rooms = Room::with('roomType')->get();
            $billroom = RoomRental::where('room_id', $id)
                ->where('status', 'unpaid')
                ->where('student_id', $student_id)
                ->with(['student', 'room' => function ($query) {
                    $query->select('room_id', 'room_name', 'room_type_id');
                }, 'room.roomType' => function ($query) {
                    $query->select('room_type_id', 'room_type_name', 'room_type_price');
                }])
                ->first();

            $template = 'admin.bill.showbillroom';
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'rooms',
                'user',
                'billroom'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function eawView($id)
    {
        if (Auth::check()) {
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId)->with('employee');
                $employee =Employee::find($user->employee_id);
                $employee_id = $user->employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $title = 'Electric and Water invoice';
            $config = $this->configCreateView();
            $rooms = Room::with('roomType')->get();
            $billEaWs = RoomBill::where('room_id', $id)->where('status', 'unpaid')->get();
            $template = 'admin.bill.showbilleaw';
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'rooms',
                'billEaWs',
                'user'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function equipmentView($id)
    {
        if (Auth::check()) {
            if (!Session::has('employee') && !Session::has('position_name')) {
                $authId = Auth::id();
                $user = User::find($authId)->with('employee');
                $employee =Employee::find($user->employee_id);
                $employee_id = $user->employee->employee_id;
                $position_name = Position::find($employee_id)->position_name;
                Session::put('employee', $employee);
                Session::put('user', $user);
                Session::put('position_name', $position_name);
            }
            $employee = Session::get('employee');
            $position_name = Session::get('position_name');
            $user = Session::get('user');
            $title = 'EquipmentView rental invoice';
            $config = $this->configCreateView();
            $rooms = Room::with('roomType')->get();
            $deviceRentails = DeviceRentalDetail::with('device')->get();
            $billEquiments = DeviceRental::where('room_id', $id)
                ->where('status', 'renting')
                ->where(DB::raw('DATEDIFF(CURDATE(), date_device_rental)'), '>=', 30)
                ->with('rentalDetails')
                ->get();
            $template = 'admin.bill.showbillequipment';
            return view('admin.dashboard.layout', compact(
                'template',
                'config',
                'title',
                'employee',
                'position_name',
                'rooms',
                'user',
                'deviceRentails',
                'billEquiments'
            ));
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function billroomPay($id)
    {
        if (Auth::check()) {
            $room_rental = RoomRental::find($id);
            if ($room_rental && $room_rental->room && $room_rental->room->roomType) {
                $roomTypePrice = $room_rental->room->roomType->room_type_price;
                $room_rental->status = 'paid';
                $room_rental->save();
                $employee = Session::get('employee');
                $bill = new Bill();
                $bill->room_id = $room_rental->room_id;
                $bill->employee_id = $employee->employee_id;
                $bill->date_bill = now()->format('Y-m-d');
                $bill->total_bill = $roomTypePrice;
                $bill->type_payment = 'Room';
                $bill->save();
                $date = date('Y-m-d', strtotime($room_rental->due_date . ' +1 month'));
                $contract = Contract::where('student_id', $room_rental->student_id)->latest('end_date')->first();
                if ($date <= date('Y-m-d', strtotime($contract->end_date . ' +1 day'))) {
                    $newRoomRental = new RoomRental();
                    $newRoomRental->room_id = $room_rental->room_id;
                    $newRoomRental->student_id = $room_rental->student_id;
                    $newRoomRental->status = 'unpaid';
                    $newRoomRental->due_date = $date;
                    $newRoomRental->save();
                }
            }
            return redirect()->route('bill.index')->with('succes', 'Make payment successfully');
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function eawPay($id)
    {
        if (Auth::check()) {
            $eawbills = RoomBill::where('room_id', $id)->where('status', 'unpaid')->get();
            $totalEaWBill = 0;
            foreach ($eawbills as $eawbill) {
                $eawbill->status = 'paid';
                $eawbill->save();
                $totalEaWBill += $eawbill->total_room_bills;
            }
            $employee = Session::get('employee');
            $bill = new Bill();
            $bill->room_id = $id;
            $bill->employee_id = $employee->employee_id;
            $bill->date_bill = now()->format('Y-m-d');
            $bill->total_bill = $totalEaWBill;
            $bill->type_payment = 'Electricity and water';
            $bill->save();
            return redirect()->route('bill.index')->with('succes', 'Make payment successfully');
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function equipmentPay($id)
    {
        if (Auth::check()) {

            if ($id) {
                $billEquiments = DeviceRental::where('room_id', $id)
                    ->where('status', 'renting')
                    ->where(DB::raw('DATEDIFF(CURDATE(), date_device_rental)'), '>=', 29)
                    ->with('rentalDetails')
                    ->get();
                foreach ($billEquiments as $billEquiment) {
                    $DeviceRental = DeviceRental::find($billEquiment->device_rental_id);
                    $DeviceRental->status = 'complete';
                    $DeviceRental->save();
                }
                $totalEquipmentBill = 0;
                foreach ($billEquiments as $billEquiment) {
                    $newDeviceRental = new DeviceRental();
                    $newDeviceRental->room_id = $id;
                    $newDeviceRental->status = 'renting';
                    $newDeviceRental->total_rental_price = $billEquiment->total_rental_price;
                    $newDeviceRental->quantity = $billEquiment->quantity;
                    $newDeviceRental->date_device_rental = now()->format('Y-m-d');
                    $newDeviceRental->save();
                    $device_rental_id = $newDeviceRental->device_rental_id;
                    foreach ($billEquiment->rentalDetails as $device_rental_details) {
                        $newDeviceRentalDetails = new DeviceRentalDetail();
                        $newDeviceRentalDetails->device_id = $device_rental_details->device_id;
                        $newDeviceRentalDetails->device_rental_id = $device_rental_id;
                        $newDeviceRentalDetails->status = 'good';
                        $newDeviceRentalDetails->rental_price = $device_rental_details->rental_price;
                        $newDeviceRentalDetails->save();
                    }
                    $totalEquipmentBill += $billEquiment->total_rental_price;
                }
                $employee = Session::get('employee');
                $bill = new Bill();
                $bill->room_id = $id;
                $bill->employee_id = $employee->employee_id;
                $bill->date_bill = now()->format('Y-m-d');
                $bill->total_bill = $totalEquipmentBill;
                $bill->type_payment = 'Equipment';
                $bill->save();
                return redirect()->route('bill.index')->with('succes', 'Make payment successfully');
            } else return redirect()->route('bill.index')->with('error', 'ID not found');
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function equipmentPayCancle($id)
    {
        if (Auth::check()) {

            if ($id) {
                $billEquiments = DeviceRental::where('room_id', $id)
                    ->where('status', 'renting')
                    ->where(DB::raw('DATEDIFF(CURDATE(), date_device_rental)'), '>=', 29)
                    ->with('rentalDetails')
                    ->get();
                $totalEquipmentBill = 0;
                foreach ($billEquiments as $billEquiment) {
                    $DeviceRental = DeviceRental::find($billEquiment->device_rental_id);
                    $DeviceRental->status = 'complete';
                    $DeviceRental->save();
                    $totalEquipmentBill += $billEquiment->total_rental_price;
                }
                $employee = Session::get('employee');
                $bill = new Bill();
                $bill->room_id = $id;
                $bill->employee_id = $employee->employee_id;
                $bill->date_bill = now()->format('Y-m-d');
                $bill->total_bill = $totalEquipmentBill;
                $bill->type_payment = 'Equipment';
                $bill->save();
                return redirect()->route('bill.index')->with('succes', 'Make payment successfully');
            } else return redirect()->route('bill.index')->with('error', 'ID not found');
        } else {
            return redirect()->route('auth.admin')->with('error', 'Please log in first');
        }
    }
    public function getRooms()
    {
        $rooms = Room::all(['room_id', 'room_name']);
        return response()->json(['rooms' => $rooms]);
    }
    public function getstudentbyid(Request $request)
    {
        $roomId = $request->room_id;
        $students = Student::whereHas('contract', function ($query) use ($roomId) {
            $query->where('room_id', $roomId);
        })->get();
        $options = '';
        foreach ($students as $student) {
            $options .= '<option value="' . $student->student_id . '">' . $student->name . '</option>';
        }
        return $options;
    }
}
