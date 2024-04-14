<?php

use App\Http\Controllers\Admin\User\AuthController;
use App\Http\Controllers\Admin\User\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::GET('admin',[AuthController::class ,'index' ])->name('auth.admin');
Route::post('login',[AuthController::class ,'login' ])->name('auth.login');

Route::GET('dashboard/index',[DashboardController::class ,'index' ])->name('dashboard.index');