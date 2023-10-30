<?php

namespace App\Http\Controllers;

use Request;
use App\Models\User;
class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return inertia('User/Index', [
            'users' => User::paginate(10)->withQueryString()->through(fn ($data, $i = 0) => [
                'name' => $data->name,
                'department' => $data->department_id ? $data->department->code : '',
                'role' => $data->role->name,
                'reg' => $data->reg ?? '',
                'phone' => $data->phone ?? '',
                'email' => $data->email ?? '',
                'reg' => $data->reg ?? '',
                'i' => $i+=1,
            ]),
            'filters' => Request::all('search', 'trashed'),
        ]);
    }


    public function create()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
