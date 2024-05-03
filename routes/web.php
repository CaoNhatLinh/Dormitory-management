<?php

use App\Http\Controllers\Admin\User\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Dashboard\EmployeeController;
use App\Http\Controllers\Admin\Dashboard\AnalysisController;
use App\Http\Controllers\Admin\Student\StudentController;
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
Route::get('employee', [EmployeeController::class, 'index'])->name('employee.index');

// STUDENT
Route::get("/student", [StudentController::class, 'index'])->name("student.index");

//GRAPH

Route::get("Analysis", [AnalysisController::class, 'index'])->name("analysis.index");

