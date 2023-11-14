<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use App\Models\Department;
use App\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Request;
use Auth;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Hash;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $users = in_array(Auth::User()->role_id, [1, 2, 3]) ? User::whereNotNull('created_at') : User::where('department_id', Auth::User()->department_id);
        return inertia('User/Index', [
            'users' => $users->paginate(8)->withQueryString()->through(fn ($data, $i = 0) => [
                'name' => $data->name,
                'reference' => $data->reference,
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


    public function store()
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['required'],
            'phone' => ['required', 'min:10', 'max:13'],
            'reg' => ['required', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'phone' => request()->phone,
            'reg' => request()->reg,
            'role_id' => request()->role_id,
            'department_id' => request()->department_id,
            'reference' => uniqid(),
            'password' => Hash::make(request()->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);
        return redirect('/users/index')->with('success', 'User added successfully');

    }

    public function edit($id)
    {
        $user = User::where('reference', $id)->first();
        $roles = Role::get(['id', 'name']);
        $departments = Department::get(['id', 'name']);
        return inertia('User/Edit', [
            'user' => $user,
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }
    public function changePassword()
    {
        return inertia('User/Password');
    }
    
    public function updatePassword()
    {
        $user = Auth::User();
        if (Hash::check(request('old_password'), $user->password)) {
           request()->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
           ]);
           $user->password = Hash::make(request('password'));
           $user->save();
           return redirect('/')->with('success', 'Password updated successfully');
        } else {
            return back()->with('error', 'Info updated successfully');
        }
    }
    
    public function update($id)
    {
        $user = User::where('reference', $id)->first();
        if (request('password')) {
            request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'department_id' => ['required'],
                'phone' => ['required', 'min:10', 'max:13'],
                'reg' => ['required',],
                'email' => ['required', 'string', 'email', 'max:255', ],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],    
            ]); 

            $user->update([
                'name' => request()->name,
                'email' => request()->email,
                'phone' => request()->phone,
                'reg' => request()->reg,
                'role_id' => request()->role_id,
                'department_id' => request()->department_id,
                'reference' => uniqid(),
                'password' => Hash::make(request()->password),
            ]);
        }else {
            request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'department_id' => ['required'],
                'phone' => ['required', 'min:10', 'max:13'],
                'reg' => ['required', ],
                'email' => ['required', 'string', 'email', 'max:255',]
            ]); 
            $user->update([
                'name' => request()->name,
                'email' => request()->email,
                'phone' => request()->phone,
                'reg' => request()->reg,
                'role_id' => request()->role_id,
                'department_id' => request()->department_id,
                'reference' => uniqid(),
            ]);
        }
        return redirect('/users/index')->with('success', 'Info updated successfully');
    }


    public function destroy($id)
    {
        $user = User::where('reference', $id)->first()->delete();
        return redirect('/users/index')->with('success', 'Info deleted successfully');
    }
}
