<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('empList', [UserController::class, 'empList'])->name('emp.list'); 
Route::get('reg-approve/{id}', [UserController::class, 'regApprove'])->name('reg.approve');

Route::get('login-form', [AuthController::class, 'index'])->name('login.form');
Route::get('index', [AuthController::class, 'dashboard'])->name('index');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 


Route::get('edit/{id}', [UserController::class, 'edit'])->name('profile');
Route::post('update', [UserController::class, 'update'])->name('profileupdate'); 

Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('applyleave', [LeaveController::class, 'applyleave'])->name('applyleave');
Route::post('post-leave', [LeaveController::class, 'postLeave'])->name('leave.post');
Route::get('all-leave', [LeaveController::class, 'allLeave'])->name('all.leave'); 
Route::get('leave-approve/{id}', [LeaveController::class, 'leaveApprove'])->name('leave.approve');
Route::get('leave-decline/{id}', [LeaveController::class, 'leaveDecline'])->name('leave.decline');


