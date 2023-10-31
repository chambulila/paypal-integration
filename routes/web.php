<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;
use App\Models\Department;

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


Route::get('/create', function(){
    return inertia('Create');
});
Route::get('/modal', function () {
    return Inertia::render('Modal');
});
Route::get('/', [LeaveRequestController::class, 'dashboard'])->name('dashboard');

//LEAVE REQUEST
Route::get('leaverequests/create', [LeaveRequestController::class, 'create'])->name('leaverequests.create');
Route::post('leaverequests/store', [LeaveRequestController::class, 'store'])->name('leaverequests.store');
Route::get('leaverequests/dashboard', [LeaveRequestController::class, 'dashboard'])->name('leaverequests.dashboard');
Route::any('leaverequests/index', [LeaveRequestController::class, 'index'])->name('leaverequests.index');
Route::get('/leaverequests/show/{id}', [LeaveRequestController::class, 'show'])->name('leaverequests.show');
Route::get('/leaverequests/updateleavestatus/{id}', [LeaveRequestController::class, 'update_leave_request_status']);
Route::post('/leaverequests/approve-reject-leave', [LeaveRequestController::class, 'approve_leave_request_status']);
Route::get('/leaverequests-print', [LeaveRequestController::class, 'index']);


Route::get('departments/create', [DepartmentController::class, 'create'])->name('departments.create');
Route::post('departments/store', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('departments/dashboard', [DepartmentController::class, 'dashboard'])->name('departments.dashboard');
Route::get('departments/index', [DepartmentController::class, 'index']);
Route::get('/departments/show/{id}', [DepartmentController::class, 'show']);

Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::get('users/import/add', [UserController::class, 'importCreate']);
Route::post('users/import/store', [UserController::class, 'importStore']);
Route::post('users/store', [UserController::class, 'store'])->name('users.store');
Route::get('users/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');
Route::get('users/index', [UserController::class, 'index']);
Route::get('/users/show/{id}', [UserController::class, 'show']);

Route::post('tests/store', [TestController::class, 'store'])->name('tests.store');
Route::get('tests/index', [TestController::class, 'index'])->name('tests.index');
require __DIR__.'/auth.php';

