<?php

use App\Http\Controllers\Admin\Contract\ContractController;
use App\Http\Controllers\Admin\User\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Employee\EmployeeController;
use App\Http\Controllers\Admin\Room\RoomController;
use App\Http\Controllers\Admin\Room\RoomTypeController;
use App\Http\Controllers\Admin\Student\StudentController;
use App\Http\Controllers\Admin\Dashboard\AnalysisController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;


Route::get('/', function () {
    return view('welcome');
});

//AUTH
Route::GET('admin', [AuthController::class, 'index'])->name('auth.admin');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

//DASHBOARD
Route::GET('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth');

//USER
Route::get("profile", [UserController::class, 'index'])->name("user.index");

// EMPLOYEE
Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');

// STUDENT
Route::get("/student", [StudentController::class, 'index'])->name("student.index");
Route::get("/student/createView", [StudentController::class, 'createView'])->name("student.createView");
Route::post("/student/create", [StudentController::class, 'create'])->name("student.create");
Route::get("/student/editView/{id}", [StudentController::class, 'editView'])->name("student.editView");
Route::post("/student/edit/{id}", [StudentController::class, 'edit'])->name("student.edit");
Route::get("/student/detailView/{id}", [StudentController::class, 'detailView'])->name("student.detailView");


// ROOM
Route::get("/room", [RoomController::class, 'index'])->name("room.index");
Route::get("/room/createView", [RoomController::class, 'createView'])->name("room.createView");
Route::post("/room/create", [RoomController::class, 'create'])->name("room.create");
Route::get("/room/editView/{id}", [RoomController::class, 'editView'])->name("room.editView");
Route::post("/room/edit/{id}", [RoomController::class, 'edit'])->name("room.edit");

// ROOM TYPE
Route::get("/room/type", [RoomTypeController::class, 'index'])->name("roomType.index");
Route::get("/room/type/createView", [RoomTypeController::class, 'createView'])->name("roomType.createView");
Route::post("/room/type/create", [RoomTypeController::class, 'create'])->name("roomType.create");
Route::get("/room/type/editView/{id}", [RoomTypeController::class, 'editView'])->name("roomType.editView");
Route::post("/room/type/edit/{id}", [RoomTypeController::class, 'edit'])->name("roomType.edit");


// CONTRACT
Route::get("/contract", [ContractController::class, 'index'])->name("contract.index");
Route::get("/contract/createView/{id}", [ContractController::class, 'createView'])->name("contract.createView");
Route::post("/contract/create/{id}", [ContractController::class, 'create'])->name("contract.create");

