<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Inertia\Inertia;
use Request;
use Auth;
use App\Models\User;

class DepartmentController extends Controller
{

    public function index()
    {
        return Inertia::render('Department/Index', [
            'users' => User::where('department_id', Auth::User()->department_id)->get()->count(),
            'can_add' => Auth::User()->role_id == 1 ? true : false,
            'filters' => Request::all('search', 'trashed'),
            'departments' => Department::paginate(10)
            ->withQueryString()
            ->through(fn ($data, $sn=0) => [
                'sn' => $sn+=1,
                'name' => $data->name,
                'code' => $data->code,
                'users' => User::where('department_id', $data->id)->get()->count(),
            ]),
        ]);
    }


    public function create()
    {
        return Inertia::render('Department/Create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        Department::create([
            'name' => request('name'),
            'code' => request('code'),
        ]);
        return redirect('/departments/index')->with('message', 'Department added successfully');
    }


    public function show($department)
    {
        return inertia('Department/Show', [
            'department' => Department::where('uuid', $department)->get()
        ]);
    }


    public function edit(Department $department)
    {
        return inertia('Department/Show', [
            'department' => Department::where('uuid', $department)->get()
        ]);
    }

 
    public function update(Request $request, $department)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        Department::where('uuid', $department)->first()->update([
            'name' => request('name'),
            'code' => request('code'),
        ]);
        return redirect('/departments/index')->with('message', 'Department updated successfully');
    }


    public function destroy(Department $department)
    {
        $department->delete();
        return redirect('/departments/index')->with('message', 'Department deleted successfully');
    }
}
