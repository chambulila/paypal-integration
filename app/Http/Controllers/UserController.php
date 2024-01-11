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



    public function create()
    {
        return view('auth.register');
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
    



    public function destroy($id)
    {
        $user = User::where('reference', $id)->first()->delete();
        return redirect('/users/index')->with('success', 'Info deleted successfully');
    }
}
