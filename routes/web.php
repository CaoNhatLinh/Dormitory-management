<?php

use App\Http\Controllers\Admin\Bill\RoomBillController;
use App\Http\Controllers\Admin\Contract\ContractController;
use App\Http\Controllers\Admin\User\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Employee\EmployeeController;
use App\Http\Controllers\Admin\Room\RoomController;
use App\Http\Controllers\Admin\Room\RoomTypeController;
use App\Http\Controllers\Admin\Student\StudentController;
use App\Http\Controllers\Admin\Employee\PositionController;
use App\Http\Controllers\Admin\Device\DeviceController;
use App\Http\Controllers\Admin\Device\DeviceTypeController;
use App\Http\Controllers\Admin\Bill\BillController;
use App\Http\Controllers\Admin\Device\DeviceRentalController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

//AUTH
Route::GET('admin', [AuthController::class, 'index'])->name('auth.admin');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
//DASHBOARD
Route::GET('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/bill-Total/{year}', [DashboardController::class, 'getMonthlyBillStatistics']);
Route::get('/bill-Cout/{year}', [DashboardController::class, 'getBillStatistics']);

//USER
Route::group(['prefix' => 'user'], function () {
    Route::get("/profile", [UserController::class, 'profileView'])->name("user.profileView");
    Route::get("", [UserController::class, 'index'])->name("user.index");
    Route::get("/createView", [UserController::class, 'createView'])->name("user.createView");
    Route::post("/create", [UserController::class, 'create'])->name("user.create");
    Route::post("/edit/{id}", [UserController::class, 'edit'])->name("user.edit");
    Route::get("/editView/{id}", [UserController::class, 'editView'])->name("user.editView");
    Route::get("/delete/{id}", [UserController::class, 'delete'])->name("user.delete");
    Route::get("/resetpassword/{id}", [UserController::class, 'resetpassword'])->name("user.resetpassword");
});
//PERMISSION
Route::group(['prefix' => 'permission'], function () {
    Route::get('', [PermissionController::class, 'index'])->name('permission.index');
    Route::get("/createView", [PermissionController::class, 'createView'])->name("permission.createView");
    Route::post("/create", [PermissionController::class, 'create'])->name("permission.create");
    Route::post("/edit", [PermissionController::class, 'edit'])->name("permission.edit");
    Route::get("/delete/{id}", [PermissionController::class, 'delete'])->name("permission.delete");
});


// EMPLOYEE
Route::group(['prefix' => 'employee'], function () {
    Route::get("", [EmployeeController::class, 'index'])->name('employee.index');
    Route::get("/createView", [EmployeeController::class, 'createView'])->name("employee.createView");
    Route::post("/create", [EmployeeController::class, 'create'])->name("employee.create");
    Route::get("/editView/{id}", [EmployeeController::class, 'editView'])->name("employee.editView");
    Route::post("/edit/{id}", [EmployeeController::class, 'edit'])->name("employee.edit");
    Route::get("/detailView/{id}", [EmployeeController::class, 'detailView'])->name("employee.detailView");
    Route::get("/delete/{id}", [EmployeeController::class, 'delete'])->name("employee.delete");
});

//POSITION
Route::group(['prefix' => 'position'], function () {
    Route::get("", [PositionController::class, 'index'])->name('position.index');
    Route::get("/createView", [PositionController::class, 'createView'])->name("position.createView");
    Route::post("/create", [PositionController::class, 'create'])->name("position.create");
    Route::post("/edit", [PositionController::class, 'edit'])->name("position.edit");
    Route::get("/delete/{id}", [PositionController::class, 'delete'])->name("position.delete");
});

// STUDENT
Route::group(['prefix' => 'student'], function () {
    Route::get("", [StudentController::class, 'index'])->name("student.index");
    Route::get("/createView", [StudentController::class, 'createView'])->name("student.createView");
    Route::post("/create", [StudentController::class, 'create'])->name("student.create");
    Route::get("/editView/{id}", [StudentController::class, 'editView'])->name("student.editView");
    Route::post("/edit/{id}", [StudentController::class, 'edit'])->name("student.edit");
    Route::get("/detailView/{id}", [StudentController::class, 'detailView'])->name("student.detailView");
});

// ROOM
Route::group(['prefix' => 'room'], function () {
    Route::get("", [RoomController::class, 'index'])->name("room.index");
    Route::get("/createView", [RoomController::class, 'createView'])->name("room.createView");
    Route::post("/create", [RoomController::class, 'create'])->name("room.create");
    Route::get("/editView/{id}", [RoomController::class, 'editView'])->name("room.editView");
    Route::post("/edit/{id}", [RoomController::class, 'edit'])->name("room.edit");

    // ROOM TYPE
    Route::group(['prefix' => 'type'], function () {
        Route::get("", [RoomTypeController::class, 'index'])->name("roomType.index");
        Route::get("/createView", [RoomTypeController::class, 'createView'])->name("roomType.createView");
        Route::post("/create", [RoomTypeController::class, 'create'])->name("roomType.create");
        Route::get("/editView/{id}", [RoomTypeController::class, 'editView'])->name("roomType.editView");
        Route::post("/edit/{id}", [RoomTypeController::class, 'edit'])->name("roomType.edit");
    });
});

// CONTRACT
Route::group(['prefix' => 'contract'], function () {
    Route::get("", [ContractController::class, 'index'])->name("contract.index");
    Route::get("/createView/{id}", [ContractController::class, 'createView'])->name("contract.createView");
    Route::post("/create/{id}", [ContractController::class, 'create'])->name("contract.create");
    Route::get("/editView/{id}", [ContractController::class, 'editView'])->name("contract.editView");
    Route::post("/edit/{id}", [ContractController::class, 'edit'])->name("contract.edit");
});
//DEVICE
Route::group(['prefix' => 'device'], function () {
    Route::get("", [DeviceController::class, 'index'])->name("device.index");
    Route::get("/createView", [DeviceController::class, 'createView'])->name("device.createView");
    Route::post("/create", [DeviceController::class, 'create'])->name("device.create");
    Route::get("/editView/{id}", [DeviceController::class, 'editView'])->name("device.editView");
    Route::post("/edit/{id}", [DeviceController::class, 'edit'])->name("device.edit");
    Route::get('/search', [DeviceController::class, 'search'])->name('device.search');
    Route::get('/delete/{id}', [DeviceController::class, 'delete'])->name('device.delete');
    Route::get("/createExcelView", [DeviceController::class, 'createExcelView'])->name("device.createExcelView");
    Route::post("/createExcel", [DeviceController::class, 'createExcel'])->name("device.createExcel");
    Route::post("/loadExcel", [DeviceController::class, 'loadExcel'])->name("device.loadExcel");
    Route::post('/rent', [DeviceRentalController::class, 'rent'])->name('device.rent');

    //DEVICE TYPE
    Route::group(['prefix' => 'devicetype'], function () {
        Route::get("", [DeviceTypeController::class, 'index'])->name("deviceType.index");
        Route::get("/createView", [DeviceTypeController::class, 'createView'])->name("deviceType.createView");
        Route::post("/create", [DeviceTypeController::class, 'create'])->name("deviceType.create");
        Route::get("/editView/{id}", [DeviceTypeController::class, 'editView'])->name("deviceType.editView");
        Route::post("/edit/{id}", [DeviceTypeController::class, 'edit'])->name("deviceType.edit");
    });

    //DEVICE RENTAL
    Route::group(['prefix' => 'devicerental'], function () {
        Route::get("", [DeviceRentalController::class, 'index'])->name("deviceRental.index");
        Route::get("/createDeviceRental", [DeviceRentalController::class, 'createDeviceRental'])->name("deviceRental.createDeviceRental");
        Route::get("/editView/{id}", [DeviceRentalController::class, 'editView'])->name("deviceRental.editView");
        Route::post("/edit/{id}", [DeviceRentalController::class, 'edit'])->name("deviceRental.edit");
    });
});

//BILL
Route::group(['prefix' => 'bill'], function () {
    Route::get("", [BillController::class, 'index'])->name("bill.index");
    Route::get("/createView", [BillController::class, 'createView'])->name("bill.createView");
    Route::post('/create', [BillController::class, 'create'])->name('bill.create');
    Route::get("/billroomView/{id}/{student_id}", [BillController::class, 'billroomView'])->name("bill.billroomView");
    Route::get("/eawView/{id}", [BillController::class, 'eawView'])->name("bill.eawView");
    Route::get("/equipmentView/{id}", [BillController::class, 'equipmentView'])->name("bill.equipmentView");

    Route::group(['prefix' => 'pay'], function () {
        Route::get("/billroom/{id}", [BillController::class, 'billroomPay'])->name("bill.billroomPay");
        Route::get("/eaw/{id}", [BillController::class, 'eawPay'])->name("bill.eawPay");
        Route::get("/equipment/{id}", [BillController::class, 'equipmentPay'])->name("bill.equipmentPay");
    });

    Route::group(['prefix' => 'room'], function () {
        // ROOM BILL
        Route::get("", [RoomBillController::class, 'index'])->name("bill.room.index");
        Route::get("/createView", [RoomBillController::class, 'createView'])->name("bill.room.createView");
        Route::post("/create", [RoomBillController::class, 'create'])->name("bill.room.create");
        Route::get("/createExcelView", [RoomBillController::class, 'createExcelView'])->name("bill.room.createExcelView");
        Route::post("/createExcel", [RoomBillController::class, 'createExcel'])->name("bill.room.createExcel");
        Route::post("/loadExcel", [RoomBillController::class, 'loadExcel'])->name("bill.room.loadExcel");
        Route::get("/editView/{id}", [RoomBillController::class, 'editView'])->name("bill.room.editView");
        Route::post("/edit/{id}", [RoomBillController::class, 'edit'])->name("bill.room.edit");
    });
});

//API
Route::get("/api/student/{id}", [BillController::class, 'getstudentbyid']);
Route::get('/api/rooms', [DeviceRentalController::class, 'getRooms']);
