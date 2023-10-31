<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
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
            'users' => User::paginate(8)->withQueryString()->through(fn ($data, $i = 0) => [
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
            'user_count' => User::count(),
        ]);
    }


    public function create()
    {
        return view('auth.register');
    }
    public function importCreate()
    {
        return inertia('User/ImportUsers');
    }

    public function importStore()
    {
        if (request()->hasFile('users')) {
            $file = request()->file('users');
            // Check if the uploaded file is an Excel file
            if ($file->getClientOriginalExtension() === 'xlsx' || $file->getClientOriginalExtension() === 'xls') {
                Excel::import(new UsersImport, $file);
                return redirect()->back()->with('success', 'Users imported successfully!');
            } else {
                return redirect()->back()->with('error', 'Please upload an Excel file (xlsx or xls).');
            }
        } else {
            return redirect()->back()->with('error', 'No file uploaded.');
        }
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
