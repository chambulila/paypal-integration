<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PaypalController;




Route::get('/', [PaypalController::class, 'dashboard'])->name('dashboard');
Route::get('/tasks', [PaypalController::class, 'tasksList'])->name('tasks.index');
Route::any('/tasks/destroy/{uuid}', [PaypalController::class, 'deleteTask'])->name('task.destroy');
Route::any('/tasks/show/{uuid}', [PaypalController::class, 'showTask'])->name('task.show');

Route::get('/create-ransaction', [PaypalController::class, 'createTask'])->name('createTransaction');
Route::post('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
Route::get('/payment-list', [PayPalController::class, 'paymentList'])->name('paymentList');


require __DIR__.'/auth.php';

