<?php

namespace App\Http\Controllers;

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
    $userRole = Auth::User()->role_id;
    $progress_requests_count = LeaveRequest::where('leave_status_id', 1)->whereNull('accept_reject_reason_four')->whereNotNull('accept_reject_reason_two')->get()->count();
    // dd($progress_requests_count);
    $leave_requests_count = LeaveRequest::whereIn('leave_status_id', [0, 1, 2])->get()->count();
    $pending_requests = LeaveRequest::whereNull('accept_reject_reason_four')->whereNotNull('accept_reject_reason_three')->where('leave_status_id', 0);
    $pending_requests_count = LeaveRequest::whereNull('accept_reject_reason_four')->whereNotNull('accept_reject_reason_three')->where('leave_status_id', 0)->count();
    $approved_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_four')->where('leave_status_id', 1)->count();
    $rejected_requests_count = LeaveRequest::where('leave_status_id', 2)->count();

    if ($userRole == 1) {
        // Rector
        // $pending_requests = $pending_requests->get()
        //     ->map(fn ($leave_request, $sn = 0) => [
        //         'sn' => $sn += 1,
        //         'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
        //         'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
        //         'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
        //         'reference' => $leave_request->reference,
        //         'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
        //         'status' => $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')),
        //         'type' => $leave_request->leaveType->name ?? '',
        //         'user' => $leave_request->user->name ?? '',
        //     ]);
        $progress_requests_count = 0;
        $leave_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_four')->get()->count();
        $pending_requests = LeaveRequest::whereNull('accept_reject_reason_four')->whereNotNull('accept_reject_reason_three')->where('leave_status_id', 1);
        $pending_requests_count = LeaveRequest::whereNull('accept_reject_reason_four')->whereNotNull('accept_reject_reason_three')->where('leave_status_id', 1)->count();
        $approved_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_four')->where('leave_status_id', 1)->count();
        $rejected_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_four')->where('leave_status_id', 2)->count();
    } elseif ($userRole == 2) {
        // HR
        $progress_requests_count = LeaveRequest::where('leave_status_id', 1)->whereNotNull('accept_reject_reason_three')->whereNull('accept_reject_reason_four')->get()->count();
        $leave_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_two')->get()->count();
        $pending_requests = LeaveRequest::whereNull('accept_reject_reason_three')->whereNotNull('accept_reject_reason_two')->where('leave_status_id', 1);
        $pending_requests_count = LeaveRequest::whereNull('accept_reject_reason_three')->whereNotNull('accept_reject_reason_two')->where('leave_status_id', 1)->count();
        $approved_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_four')->where('leave_status_id', 1)->count();
        $rejected_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_three')->where('leave_status_id', 2)->count();
    } elseif ($userRole == 3) {
        // Dean
        $progress_requests_count = LeaveRequest::where('leave_status_id', 1)->whereNull('accept_reject_reason_four')->whereNotNull('accept_reject_reason_two')->get()->count();
        $leave_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_one')->get()->count();
        $pending_requests = LeaveRequest::whereNull('accept_reject_reason_two')->whereNotNull('accept_reject_reason_one')->where('leave_status_id', 1);
        $pending_requests_count = LeaveRequest::whereNull('accept_reject_reason_two')->whereNotNull('accept_reject_reason_one')->where('leave_status_id', 1)->count();
        $approved_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_four')->where('leave_status_id', 1)->count();
        $rejected_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_two')->where('leave_status_id', 2)->count();
    } elseif ($userRole == 4) {
        // HoD
        $progress_requests_count = LeaveRequest::where('leave_status_id', 1)->whereNull('accept_reject_reason_four')->get()->count();
        $leave_requests_count = LeaveRequest::whereNull('accept_reject_reason_one')->orWhereNotNull('accept_reject_reason_one')->get()->count();
        $leave_requests_count = LeaveRequest::whereNull('accept_reject_reason_one')->orWhereNotNull('accept_reject_reason_one')->count();
        $pending_requests = LeaveRequest::whereNull('accept_reject_reason_one')->where('leave_status_id', 0);
        $pending_requests_count = LeaveRequest::whereNull('accept_reject_reason_one')->where('leave_status_id', 0)->count();
        $approved_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_four')->where('leave_status_id', 1)->get()->count();
        $rejected_requests_count = LeaveRequest::whereNotNull('accept_reject_reason_one')->where('leave_status_id', 2)->count();
    } elseif ($userRole == 5) {
        // Staff
        $progress_requests_count = LeaveRequest::where('leave_status_id', 1)->whereNull('accept_reject_reason_four')->where('user_id', Auth::User()->id)->get()->count();
        $leave_requests_count = LeaveRequest::where('user_id', Auth::User()->id)->count();
        $pending_requests = LeaveRequest::where('user_id', Auth::User()->id)->where('leave_status_id', 0);
        $pending_requests_count = LeaveRequest::where('user_id', Auth::User()->id)->where('leave_status_id', 0)->count();
        $approved_requests_count = LeaveRequest::where('user_id', Auth::User()->id)->whereNotNull('accept_reject_reason_four')->where('leave_status_id', 1)->get()->count();
        $rejected_requests_count = LeaveRequest::where('user_id', Auth::User()->id)->where('leave_status_id', 2)->count();
    }

    $userRole = Auth::user()->role_id;

// Mchagua jinsi ya kuonesha statasi kulingana na jukumu la mtumiaji
if ($userRole == 5) {
    $pending_requests = $pending_requests->get()->map(fn ($leave_request, $sn = 0) => [
        'sn' => $sn += 1,
        'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
        'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
        'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
        'reference' => $leave_request->reference,
        'type' => $leave_request->leaveType->name ?? '',
        'user' => $leave_request->user->name ?? '',
        'status' => $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')) 
    ]);
} elseif ($userRole == 4) {
    $pending_requests = $pending_requests->get()->map(fn ($leave_request, $sn = 0) => [
        'sn' => $sn += 1,
        'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
        'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
        'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
        'reference' => $leave_request->reference,
        'type' => $leave_request->leaveType->name ?? '',
        'user' => $leave_request->user->name ?? '',
        'status' => $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending'))  
    ]);
} elseif ($userRole == 3) {
    $pending_requests = $pending_requests->get()->map(fn ($leave_request, $sn = 0) => [
        'sn' => $sn += 1,
        'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
        'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
        'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
        'reference' => $leave_request->reference,
        'type' => $leave_request->leaveType->name ?? '',
        'user' => $leave_request->user->name ?? '',
        'status' => $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_two !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')) 
    ]);
} elseif ($userRole == 2) {
    $pending_requests = $pending_requests->get()->map(fn ($leave_request, $sn = 0) => [
        'sn' => $sn += 1,
        'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
        'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
        'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
        'reference' => $leave_request->reference,
        'type' => $leave_request->leaveType->name ?? '',
        'user' => $leave_request->user->name ?? '',
        'status' => $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_three !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')) 
    ]);
} else {
        $pending_requests = $pending_requests->get()->map(fn ($leave_request, $sn = 0) => [
            'sn' => $sn += 1,
            'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
            'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
            'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
            'reference' => $leave_request->reference,
            'type' => $leave_request->leaveType->name ?? '',
            'user' => $leave_request->user->name ?? '',
            'status' => $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending'))
        ]);
}

    // $pending_requests = $pending_requests->map(fn ($leave_request, $sn = 0) => [
    //     'sn' => $sn += 1,
    //     'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
    //     'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
    //     'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
    //     'reference' => $leave_request->reference,
    //     'type' => $leave_request->leaveType->name ?? '',
    //     'user' => $leave_request->user->name ?? '',
    //     'status' => Auth::User()->role_id == 5 ? $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')) 
    //     : (Auth::User()->role_id == 4 ? $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending'))  
    //     :  (Auth::User()->role_id == 3 ? $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_two !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')) 
    //     : (Auth::User()->role_id == 2 ? $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_three !== null && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')) 
    //     : $leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')))))

    // ]);

    return Inertia::render('LeaveRequest/Dashboard', [
        'user' => Auth::User()->name,
        'leave_requests_count' => $leave_requests_count,
        'pending_requests' => $pending_requests,
        'pending_requests_count' => $pending_requests_count,
        'approved_requests_count' => $approved_requests_count,
        'rejected_requests_count' => $rejected_requests_count,
        'progress_requests_count' => $progress_requests_count,
    ]);
}



function getStatusForRole($leave_request, $role_id)
{
    $inProgressStatus = 'In Progress';
    $rejectedStatus = 'Rejected';
    $approvedStatus = 'Approved';
    $pendingStatus = 'Pending';

    if ($role_id == 5) {
        return $leave_request->leave_status_id == 1 && is_null($leave_request->accept_reject_reason_four) ? $inProgressStatus : (
            $leave_request->leave_status_id == 2 ? $rejectedStatus : (
                $leave_request->leave_status_id == 1 && !is_null($leave_request->accept_reject_reason_four) ? $approvedStatus : $pendingStatus
            )
        );
    } elseif ($role_id == 4) {
        return $leave_request->leave_status_id == 1 && is_null($leave_request->accept_reject_reason_four) ? $inProgressStatus : (
            $leave_request->leave_status_id == 2 ? $rejectedStatus : (
                $leave_request->leave_status_id == 1 && !is_null($leave_request->accept_reject_reason_four) ? $approvedStatus : $pendingStatus
            )
        );
    } elseif ($role_id == 3) {
        return $leave_request->leave_status_id == 1 && !is_null($leave_request->accept_reject_reason_two) && is_null($leave_request->accept_reject_reason_four) ? $inProgressStatus : (
            $leave_request->leave_status_id == 2 ? $rejectedStatus : (
                $leave_request->leave_status_id == 1 && !is_null($leave_request->accept_reject_reason_four) ? $approvedStatus : $pendingStatus
            )
        );
    } elseif ($role_id == 2) {
        return $leave_request->leave_status_id == 1 && !is_null($leave_request->accept_reject_reason_three) && is_null($leave_request->accept_reject_reason_four) ? $inProgressStatus : (
            $leave_request->leave_status_id == 2 ? $rejectedStatus : (
                $leave_request->leave_status_id == 1 && !is_null($leave_request->accept_reject_reason_four) ? $approvedStatus : $pendingStatus
            )
        );
    } else {
        return $leave_request->leave_status_id == 1 && is_null($leave_request->accept_reject_reason_four) ? $inProgressStatus : (
            $leave_request->leave_status_id == 2 ? $rejectedStatus : (
                $leave_request->leave_status_id == 1 && !is_null($leave_request->accept_reject_reason_four) ? $approvedStatus : $pendingStatus
            )
        );
    }
}


function determineStatus($leave_request, $userRole)
{
    if ($userRole == 5) {
        if ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four == null) {
            return 'In Progress';
        } elseif ($leave_request->leave_status_id == 2) {
            return 'Rejected';
        } elseif ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null) {
            return 'Approved';
        }
    } elseif ($userRole == 4) {
        if ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_one !== null && $leave_request->accept_reject_reason_four == null) {
            return 'In Progress';
        } elseif ($leave_request->leave_status_id == 2) {
            return 'Rejected';
        } elseif ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null) {
            return 'Approved';
        }
    } elseif ($userRole == 3) {
        if ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_two !== null && $leave_request->accept_reject_reason_four == null) {
            return 'In Progress';
        } elseif ($leave_request->leave_status_id == 2) {
            return 'Rejected';
        } elseif ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null) {
            return 'Approved';
        }
    } elseif ($userRole == 2) {
        if ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_three !== null && $leave_request->accept_reject_reason_four == null) {
            return 'In Progress';
        } elseif ($leave_request->leave_status_id == 2) {
            return 'Rejected';
        } elseif ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null) {
            return 'Approved';
        }
    } else {
        if ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_two !== null && $leave_request->accept_reject_reason_four == null) {
            return 'In Progress';
        } elseif ($leave_request->leave_status_id == 2) {
            return 'Rejected';
        } elseif ($leave_request->leave_status_id == 1 && $leave_request->accept_reject_reason_four !== null) {
            return 'Approved';
        }
    }

    // Default status
    return 'Pending';
}


    public function index()
    {
        // dd(request()->all());
        $month = empty(!request('month')) ? Carbon::parse(request('month')) : null;
        $ltype = !empty(request('ltype')) ? [(int)request('ltype')] : '';
        $leave_requests = LeaveRequest::whereNotNull('created_at');
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
        // $isParent = Auth::User()->account_type_id == 3 ? true : false;
        $types = LeaveType::get(['id', 'name']);
        $reasons = LeaveReason::get(['id', 'name']);
        $start_date = now()->addDays(14)->toDateString();
        // dd(date("d-m-Y", strtotime($start_date)));
        // if ($isParent) {
        //     $studentIds = Auth::User()->studentParents->pluck('student_id');
        //     $students = \App\Models\Student::whereIn('id', $studentIds)->get(['id', 'name']);
        //     return Inertia::render('LeaveRequest/Create', [
        //         'leave_type' => $types,
        //         'start_date' => $start_date,
        //         'reasons' => $reasons,
        //         'students' => count($students) > 0 ? $students : null,
        //     ]);
        // }else{
            return Inertia::render('LeaveRequest/Create', [
                'leave_type' => $types,
                '_date' => $start_date,
                'todate' => now()->toDateString(),
                'reasons' => $reasons,
            ]);
        // }
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
            ]);
        }
        return redirect('/leaverequests/index')->with('message', 'Request submitted successfully');
    }


    public function show($id)
    {
        $leave_request = LeaveRequest::with('user', 'leavestatus')->where('reference', $id)->get()->map(fn ($leave_request) => [
            'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
            'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
            'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
            'reference' => $leave_request->reference,
            'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
            'leave_status_id' => $leave_request->leave_status_id,
            'note' => $leave_request->note,
            'attachment' => $leave_request->attachment,
            'status' => $leave_request->leave_status_id == 1  && $leave_request->accept_reject_reason_four == null ? 'In Progress' : ($leave_request->leave_status_id == 2 ? 'Rejected' : ($leave_request->leave_status_id == 1  &&  $leave_request->accept_reject_reason_four !== null ? 'Approved' : 'Pending')),
            'type' => $leave_request->leavetype->name,
            'position' => $leave_request->accept_reject_reason_one == null ? 'HoD Stage' : ($leave_request->accept_reject_reason_two == null ? 'Dean Stage' : ($leave_request->accept_reject_reason_three == null ? 'HR Stage' : 'Rector Stage')),
            // 'inNeed' => $leave_request->student->name,
            'user' => $leave_request->user->name,
            'role' => $leave_request->user->role->name,
            'role_id' => $leave_request->user->role->id,
            'reason' => $leave_request->leaveReason->name,
        ])->first();


        return Inertia::render('LeaveRequest/Show', [ 
        'back_url' => url()->previous(),
        'leave_request' => $leave_request,
        'canManage' =>  Auth::User()->role_id !== 5 && $leave_request['role_id'] !== Auth::User()->role_id ? true : false ,            
    ]);
    }


}