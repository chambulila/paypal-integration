<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\LeaveReason;
use App\Models\LeaveStatus;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use Request;
use PDF;

class LeaveRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    } 


public function dashboard()
{
    return Inertia::render('Paypal/Dashboard');
}










    public function index()
    {
        // dd(request()->all());
        $month = empty(!request('month')) ? Carbon::parse(request('month')) : null;
        $ltype = !empty(request('ltype')) ? [(int)request('ltype')] : '';
        $leave_requests = in_array(Auth::User()->role_id, [1, 2, 3]) ? LeaveRequest::whereNotNull('created_at') : LeaveRequest::where('department_id', Auth::User()->department_id);
        if(Auth::User()->role_id == 1){
            if (request('read') == 'progress') {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_four')->whereNull('accept_reject_reason_four');
            }elseif (request('read') == 'approved' ) {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_four');
            }elseif (request('read') == 'pending'){
                $leave_requests->where('leave_status_id', 1)->whereNull('accept_reject_reason_four')->whereNotNull('accept_reject_reason_three');
            }elseif(request('read') == 'rejected'){
                $leave_requests->where('leave_status_id', 2)->whereNotNull('accept_reject_reason_four');
            }
            if (request('search')) {
                $leave_requests->whereIn('user_id', \App\Models\User::where(DB::raw('lower(name)') , 'like', '%'.strtolower(request('search')).'%')->get('id'));
            }
            $leave_requests = $leave_requests->filter(Request::only('search', 'trashed'))
            ->paginate(20)
            ->withQueryString()
            ->through(fn ($leave_request, $i=0) => [
                'i' => $i+=1,
                'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
                'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
                'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
                'reference' => $leave_request->reference,
                'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
                'status' => $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_four !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')),
                'type' => $leave_request->leaveType->name,
                'user' => $leave_request->user->name,
                'position' => $leave_request->accept_reject_reason_one == null ? 'HoD Stage' : ($leave_request->accept_reject_reason_two == null ? 'Dean Stage' : ($leave_request->accept_reject_reason_three == null ? 'HR Stage' : 'Rector Stage')),
            ]);
        }elseif(Auth::User()->role_id == 2){
            //HR
            if (request('read') == 'progress') {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_three')->whereNull('accept_reject_reason_four');
            }elseif (request('read') == 'approved' ) {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_four');
            }elseif (request('read') == 'pending'){
                $leave_requests->where('leave_status_id', 1)->whereNull('accept_reject_reason_three')->whereNotNull('accept_reject_reason_two');
            }elseif(request('read') == 'rejected'){
                $leave_requests->where('leave_status_id', 2)->whereNotNull('accept_reject_reason_three');
            }else{
                $leave_requests->where('user_id', Auth::user()->id);
            }
            if (request('search')) {
                $leave_requests->whereIn('user_id', \App\Models\User::where(DB::raw('lower(name)'), 'like', "%".request('search')."%")->get(['id']));
            }
            if (request('search')) {
                $leave_requests->whereIn('user_id', \App\Models\User::where(DB::raw('lower(name)') , 'like', '%'.strtolower(request('search')).'%')->get('id'));
            }
            $leave_requests = $leave_requests->filter(Request::only('search', 'trashed'))
            ->paginate(20)
            ->withQueryString()
            ->through(fn ($leave_request, $i=0) => [
                'i' => $i+=1,
                'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
                'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
                'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
                'reference' => $leave_request->reference,
                'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
                'status' => $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_three !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')),
                'type' => $leave_request->leaveType->name,
                'user' => $leave_request->user->name,
                'position' => $leave_request->accept_reject_reason_four == null && $leave_request->accept_reject_reason_three !== null ? 'Rector' : ($leave_request->accept_reject_reason_three == null && $leave_request->accept_reject_reason_two !== null ? 'HR' : ($leave_request->accept_reject_reason_two == null && $leave_request->accept_reject_reason_one !== null ? 'Dean' : 'HoD Stage')),
            ]);
        }elseif(Auth::User()->role_id == 3){
            //dean
            if (request('read') == 'progress') {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_two')->whereNull('accept_reject_reason_four');
            }elseif (request('read') == 'approved' ) {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_four');
            }elseif (request('read') == 'pending'){
                $leave_requests->where('leave_status_id', 1)->whereNull('accept_reject_reason_two')->whereNotNull('accept_reject_reason_one');
            }elseif(request('read') == 'rejected'){
                $leave_requests->where('leave_status_id', 2)->whereNotNull('accept_reject_reason_two');
            }else{
                $leave_requests->where('user_id', Auth::user()->id);
            }
            if (request('search')) {
                $leave_requests->whereIn('user_id', \App\Models\User::where(DB::raw('lower(name)') , 'like', '%'.strtolower(request('search')).'%')->get('id'));
            }
            $leave_requests = $leave_requests->filter(Request::only('search', 'trashed'))
        ->paginate(20)
        ->withQueryString()
        ->through(fn ($leave_request, $i=0) => [
            'i' => $i+=1,
            'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
            'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
            'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
            'reference' => $leave_request->reference,
            'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
            'status' => $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_two !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')),
            'type' => $leave_request->leaveType->name,
            'user' => $leave_request->user->name,
            'position' => $leave_request->accept_reject_reason_one == null ? 'HoD Stage' : ($leave_request->accept_reject_reason_two == null ? 'Dean Stage' : ($leave_request->accept_reject_reason_three == null ? 'HR Stage' : 'Rector Stage')),
        ]);
        }elseif(Auth::User()->role_id == 4){
            //HoD
            if (request('read') == 'progress') {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_one')->whereNull('accept_reject_reason_four');
            }elseif (request('read') == 'approved' ) {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_four');
            }elseif (request('read') == 'pending'){
                $leave_requests->where('leave_status_id', 0);
            }elseif(request('read') == 'rejected'){
                $leave_requests->where('leave_status_id', 2)->whereNotNull('accept_reject_reason_one');
            }else{
                // $leave_requests->where('user_id', Auth::user()->id);
                $leave_requests = $leave_requests;
            }
            if (request('search')) {
                $leave_requests->whereIn('user_id', \App\Models\User::where(DB::raw('lower(name)') , 'like', '%'.strtolower(request('search')).'%')->get('id'));
            }
            $leave_requests = $leave_requests->paginate(20)
            ->withQueryString()
            ->through(fn ($leave_request, $i=0) => [
                'i' => $i+=1,
                'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
                'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
                'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
                'reference' => $leave_request->reference,
                'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
                'status' => $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_one !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')),
                'type' => $leave_request->leaveType->name,
                'user' => $leave_request->user->name,
                'position' => $leave_request->accept_reject_reason_one == null ? 'HoD Stage' : ($leave_request->accept_reject_reason_two == null ? 'Dean Stage' : ($leave_request->accept_reject_reason_three == null ? 'HR Stage' : 'Rector Stage')),
            ]);
        }elseif(Auth::User()->role_id == 5){
            //staff
            if (request('read') == 'progress') {
                $leave_requests->where('leave_status_id', 1)->whereNull('accept_reject_reason_four')->where('user_id', Auth::user()->id);
            }elseif (request('read') == 'approved' ) {
                $leave_requests->where('leave_status_id', 1)->whereNotNull('accept_reject_reason_four')->where('user_id', Auth::user()->id);
            }elseif (request('read') == 'pending'){
                $leave_requests->where('leave_status_id', 0)->where('user_id', Auth::user()->id);
            }elseif(request('read') == 'rejected'){
                $leave_requests->where('leave_status_id', 2)->where('user_id', Auth::user()->id);
            }else{
                $leave_requests->where('user_id', Auth::user()->id);
            }
            $leave_requests = $leave_requests->filter(Request::only('search', 'trashed'))
            ->paginate(20)
            ->withQueryString()
            ->through(fn ($leave_request, $i=0) => [
                'i' => $i+=1,
                'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
                'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
                'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
                'reference' => $leave_request->reference,
                'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
                'status' => $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')),
                'type' => $leave_request->leaveType->name,
                'user' => $leave_request->user->name,
                'position' => $leave_request->accept_reject_reason_one == null ? 'HoD Stage' : ($leave_request->accept_reject_reason_two == null ? 'Dean Stage' : ($leave_request->accept_reject_reason_three == null ? 'HR Stage' : 'Rector Stage')),
            ]);
        }
        if ($month !== null && !empty($ltype) ) {
            $leave_requests->whereYear('created_at', $month)->whereMonth('created_at', $month)->whereIn('leave_type_id', $ltype);
        }elseif ($month !== null) {
            $leave_requests->whereYear('created_at', $month)->whereMonth('created_at', $month);
        }elseif (!$ltype == '') {
            $leave_requests->whereIn('leave_type_id', $ltype);
        }
        if(request('read') == 'print'){
            $this->data['leaverequest'] = $leave_requests->get();
            $pdf = PDF::loadView("print.leaverequest", $this->data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('leaverequest'.$month.'.pdf');
            exit;
        }
        return Inertia::render('LeaveRequest/Index', [
            'back_url' => url()->previous(),
            'leave_requests' => $leave_requests,
            'success' => 'leave',
            'filters' => Request::all('search', 'trashed'),
            'leavetypes' => LeaveType::get(['id', 'name']),
            'readStatus' => request('read'),
            'month' => empty(!request('month')) ? Carbon::parse(request('month')) : null,
            'ltype' => !empty(request('ltype')) ? [(int)request('ltype')] : 0,
            'leave_count' => LeaveRequest::count(),
        ]);
    }

    public function approve_leave_request_status()
    {
        $id = request('reference');
        $action = request('action');
        $reason = request('accept_reject_reason');
        $leave = LeaveRequest::where('reference', $id)->first();
        if (!$leave) {
            return redirect()->back()->with('error', 'Leave request not found');
        }
    
        if ($action == "approve") {
            $leave->leave_status_id = 1;
            $request = $this->chooseAcceptRejectReasonColumn($leave);
            $leave->$request = $reason;
            $leave->save();
            return redirect()->route('leaverequests.show', $id)->with('message', 'Request has been approved successfully');
        } elseif ($action == "reject") {
            $leave->leave_status_id = 2;
            $request = $this->chooseAcceptRejectReasonColumn($leave);
            $leave->$request = $reason;
            $leave->save();
            return redirect()->route('leaverequests.show', $id)->with('message', 'Request has been rejected successfully');
        } else {
            return redirect()->back()->with('error', 'Invalid action');
        }
    }
    
    private function chooseAcceptRejectReasonColumn($leave)
    {
        if (Auth::User()->role_id == 4) {
            return 'accept_reject_reason_one';
        } elseif ( Auth::User()->role_id == 3) {
            return 'accept_reject_reason_two';
        } elseif ( Auth::User()->role_id == 2) {
            return 'accept_reject_reason_three';
        } elseif ( Auth::User()->role_id == 1) {
            return 'accept_reject_reason_four';
        }
    }
    


    public function create()
    {
            return Inertia::render('LeaveRequest/Create', [
                'leave_type' => LeaveType::get(['id', 'name']),
                '_date' => now()->addDays(14)->toDateString(),
                'todate' => now()->toDateString(),
                'reasons' =>  LeaveReason::get(['id', 'name']),
            ]);
    }


    public function store(\Illuminate\Http\Request $request)
    {
        $validated =$request->validate([
            'note' => ['required', 'string'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'leave_type_id' => ['required'],
            'leave_reason' => ['required'],
            'attachment' => ['mimes:png,jpg,jpeg|max:2048|pdf'],
        ]);

        if ($request->hasFile('image')) {
            $attachemt_path = time() . '.' . $request->image->extension();
            $request->image->move(public_path('image'), $attachemt_path);
            LeaveRequest::create([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'leave_type_id' => $request->leave_type_id,
                'leave_reason_id' => $request->leave_reason,
                'reference' => uniqid(),
                'user_id' => Auth::user()->id ?? 1,
                'attachment' => $attachemt_path,
                'department_id' => Auth::User()->department_id,
            ]);
        } else {
            LeaveRequest::create([
                'note' => $request->note,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'leave_type_id' => $request->leave_type_id,
                'leave_reason_id' => $request->leave_reason,
                'reference' => uniqid(),
                'user_id' => Auth::user()->id,
                'department_id' => Auth::User()->department_id,
            ]);
        }
        return redirect('/leaverequests/index')->with('message', 'Request submitted successfully');
    }


    public function show($id)
    {
        $admin_dept = Auth::User()->department_id;
        $role = Auth::User()->role_id;
        $leave_request = LeaveRequest::with('user', 'leavestatus')->where('reference', $id)->get()->map(fn ($leave_request) => [
            'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
            'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
            'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
            'reference' => $leave_request->reference,
            'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
            'leave_status_id' => $leave_request->leave_status_id,
            'note' => $leave_request->note,
            'attachment' => $leave_request->attachment,
            'status' => $role == 1 ? $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_four !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending'))
                            : ($role == 2 ? $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_three !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending'))
                            : ($role == 3 ? $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_two !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending'))
                            : ($role == 4 ? $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_one !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending'))
                            : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')))))),
            // 'status' => $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')),
            'type' => $leave_request->leavetype->name,
            'position' => $leave_request->accept_reject_reason_one == null ? 'HoD Stage' : ($leave_request->accept_reject_reason_two == null ? 'Dean Stage' : ($leave_request->accept_reject_reason_three == null ? 'HR Stage' : 'Rector Stage')),
            'user' => $leave_request->user->name,
            'role' => $leave_request->user->role->name,
            'role_id' => $leave_request->user->role->id,
            'reason' => $leave_request->leaveReason->name,
        ])->first();


        return Inertia::render('LeaveRequest/Show', [ 
        'back_url' => url()->previous(),
        'leave_request' => $leave_request,
        'canManage' =>  Auth::User()->role_id !== 5 && $leave_request['role_id'] !== Auth::User()->role_id && $leave_request['status'] !== 'Rejected' ? true : false ,            
    ]);
    }
}