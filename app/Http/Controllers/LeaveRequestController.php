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
        // if (Auth::User()->account_type_id == 1) {
            return Inertia::render('LeaveRequest/Dashboard', [
                'leave_requests_count' => LeaveRequest::count(),
                'approved_requests' => LeaveRequest::latest()->where('leave_status_id', 1)->take(5)->get()
                ->map(fn ($item) => [
                    'name' => $item->user->name,
                    'username' => $item->user->username,
                    'leavetype' => $item->leavetype->name,
                    'status' => $item->leavestatus->status,
                    'start_date' => $item->start_date,
                    'end_date' => $item->end_date, 
                    'reference' => $item->reference,
    
                ] ),
                'pending_requests' => LeaveRequest::latest()->where('leave_status_id', 0)->take(5)->get()
                ->map(fn ($leave_request) => [
                    'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
                    'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
                    'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
                    'reference' => $leave_request->reference,
                    'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
                    'status' => $leave_request->leave_status_id === 0 ? 'Pending' : ($leave_request->leave_status_id === 1 ? 'Approved' : 'Rejected'),
                    'type' => $leave_request->leavetype->name,
                    'user' => $leave_request->user->name
                    ] ),
                'pending_requests_count' => LeaveRequest::where('leave_status_id', 0)->get()->count(),
                'approved_requests_count' => LeaveRequest::where('leave_status_id', 1)->get()->count(),
                'rejected_requests_count' => LeaveRequest::where('leave_status_id', 2)->get()->count(),
            ]);
        // }else{
        //     return Inertia::render('LeaveRequest/Dashboard', [
        //         'leave_requests_count' => LeaveRequest::where('school_id', Auth::User()->school_id)->where('user_id', Auth::User()->id)->count(),
        //         'approved_requests' => LeaveRequest::where('school_id', Auth::User()->school_id)->where('user_id', Auth::User()->id)->latest()->where('leave_status_id', 1)->take(5)->get()
        //         ->map(fn ($item) => [
        //             'name' => $item->user->name,
        //             'username' => $item->user->username,
        //             'leavetype' => $item->leavetype->name,
        //             'status' => $item->leavestatus->status,
        //             'start_date' => $item->start_date,
        //             'end_date' => $item->end_date, 
        //             'reference' => $item->reference,
    
        //         ] ),
        //         'pending_requests' => LeaveRequest::where('school_id', Auth::User()->school_id)->where('user_id', Auth::User()->id)->latest()->where('leave_status_id', 0)->take(5)->get()
        //         ->map(fn ($item) => [
        //                 'name' => $item->user->name,
        //                 'username' => $item->user->username,
        //                 'leavetype' => $item->leavetype->name,
        //                 'status' => $item->leavestatus->status,
        //                 'start_date' => $item->start_date,
        //                 'end_date' => $item->end_date,
        //                 'reference' => $item->reference,
        //             ] ),
        //         'pending_requests_count' => LeaveRequest::where('school_id', Auth::User()->school_id)->where('user_id', Auth::User()->id)->where('leave_status_id', 0)->get()->count(),
        //         'approved_requests_count' => LeaveRequest::where('school_id', Auth::User()->school_id)->where('user_id', Auth::User()->id)->where('leave_status_id', 1)->get()->count(),
        //         'rejected_requests_count' => LeaveRequest::where('school_id', Auth::User()->school_id)->where('user_id', Auth::User()->id)->where('leave_status_id', 2)->get()->count(),
        //     ]);
        // }
 

    }

    public function index()
    {
        $month = empty(!request('month')) ? Carbon::parse(request('month')) : null;
        $ltype = !empty(request('ltype')) ? [(int)request('ltype')] : '';
        $leave_requests = request('read') == 'pending' ? 
        LeaveRequest::where('leave_status_id', 0) : (request('read') == 'approved' ? LeaveRequest::where('leave_status_id', 1) : 
                (request('read') == 'rejected' ? LeaveRequest::where('leave_status_id', 2) : LeaveRequest::latest()));
        if ($month !== null && !empty($ltype) ) {
            $leave_requests->whereYear('created_at', $month)->whereMonth('created_at', $month)->whereIn('leavetype_id', $ltype);
        }elseif ($month !== null) {
            $leave_requests->whereYear('created_at', $month)->whereMonth('created_at', $month);
        }elseif (!$ltype == '') {
            $leave_requests->whereIn('leavetype_id', $ltype);
        }
        if(request('read') == 'print'){
            $this->data['leaverequest'] = $leave_requests->get();
            $pdf = PDF::loadView("print.leaverequest", $this->data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('leaverequest'.$month.'.pdf');
            exit;
        }
 
        $leave_requests = $leave_requests->filter(Request::only('search', 'trashed'))
        ->paginate(1)
        ->withQueryString()
        ->through(fn ($leave_request, $i=1) => [
            'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
            'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
            'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
            'reference' => $leave_request->reference,
            'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
            'status' => $leave_request->leave_status_id === 0 ? 'Pending' : ($leave_request->leave_status_id === 1 ? 'Approved' : 'Rejected'),
            'type' => $leave_request->leaveType->name,
            'user' => $leave_request->user->name
        ]);
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

    public function approve_leave_request_status($id)
    {
        if ($id != '') {
            LeaveRequest::where('school_id', Auth::User()->school_id)->where('reference', $id)->first()->update(['leave_status_id' => 1]);
            return redirect()->route('leaverequests.show', $id)->with('message', 'Request has been approved successfully');
        } else {
            return redirect()->back();
        }
    }

    public function reject_leave_request_status($id)
    {
        if ($id != '') {
            LeaveRequest::where('school_id', Auth::User()->school_id)->where('reference', $id)->first()->update(['leave_status_id' => 2]);
            return redirect()->route('leaverequests.show', $id)->with('message', 'Request has been rejected successfully');
        } else {
            return redirect()->back();
        }
    }

    public function create()
    {
        // $isParent = Auth::User()->account_type_id == 3 ? true : false;
        $types = LeaveType::get(['id', 'name']);
        $reasons = LeaveReason::get(['id', 'name']);
        $start_date = Carbon::now()->toDateString();
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
                'start_date' => $start_date,
                'reasons' => $reasons,
            ]);
        // }
    }


    public function store(\Illuminate\Http\Request $request)
    {
            Validator::make($request->all(), [
            'note' => ['required', 'string'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'leave_type_id' => ['required'],
            'leave_reason' => ['required'],
            'attachment' => ['mimes:png,jpg,jpeg|max:2048|pdf'],
        ]);
// dd($request->all());
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
        return redirect('/leaverequests/index')->with('success', 'Request submitted successfully');
    }


    public function show($id)
    {
        $leave_request = LeaveRequest::with('user', 'leavestatus')->where('reference', $id)->first();
        $leave_request =  [
            'start_date' => date("M d, Y", strtotime($leave_request->start_date)),
            'end_date' => date("M d, Y", strtotime($leave_request->end_date)),
            'number_of_days' => Carbon::parse($leave_request->end_date)->diffInDays(Carbon::parse($leave_request->start_date)),
            'reference' => $leave_request->reference,
            'created_at' => date("M d-Y", strtotime($leave_request->created_at)),
            'leave_status_id' => $leave_request->leave_status_id,
            'note' => $leave_request->note,
            'attachment' => $leave_request->attachment,
            'status' => $leave_request->leave_status_id === 0 ? 'Pending' : ($leave_request->leave_status_id === 1 ? 'Approved' : 'Rejected'),
            'type' => $leave_request->leavetype->name,
            // 'inNeed' => $leave_request->student->name,
            'user' => $leave_request->user->name,
            'role' => $leave_request->user->username,
            'reason' => $leave_request->leaveReason->name,
        ];

        return Inertia::render('LeaveRequest/Show', [ 
        'back_url' => url()->previous(),
        'leave_request' => $leave_request,
        // 'can_manage' =>  Auth::User()->account_type_id == 1 ? true : false,            
    ]);
    }


}