<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LeaveRequestController;

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
Route::get('leaverequest/dashboard', [LeaveRequestController::class, 'dashboard'])->name('leaverequests.dashboard');
Route::get('leaverequests/index', [LeaveRequestController::class, 'index'])->name('leaverequests.index');
Route::get('/leaverequests/show/{id}', [LeaveRequestController::class, 'show'])->name('leaverequests.show');
Route::get('/leaverequests/updateleavestatus/{id}', [LeaveRequestController::class, 'update_leave_request_status']);
Route::get('/leaverequests/approveleavestatus/{id}', [LeaveRequestController::class, 'approve_leave_request_status']);
Route::get('/leaverequests/rejectleavestatus/{id}', [LeaveRequestController::class, 'reject_leave_request_status']);
Route::get('/leaverequests-print', [LeaveRequestController::class, 'index']);
require __DIR__.'/auth.php';
