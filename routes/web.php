<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
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
    return Inertia::render('About', [
        'tasks' => [
            ['name' => 'Ammon Mkama',
            'age' => '25',
            'phone' => '07890987876',
            'id' => '07890987876'],
             ['name' => 'Ammon Mkama',
            'age' => '25',
            'phone' => '07890987876',
            'id' => '07890987876'],
        ]
    ]);
});
Route::get('/create', function(){
    return inertia('Create');
});
Route::get('/modal', function () {
    return Inertia::render('Modal');
});