<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeaveRequest extends Model
{
    public $table = 'leave_requests';
    protected $primaryKey = 'id';
    protected $fillable = ['uuid', 'id', 'note', 'start_date', 'reference', 'end_date', 'leave_status_id', 'department_id', 'leave_reason_id', 'leave_type_id','approval_date', 'user_id', 'attachment',  'updated_at', 'created_at'];


    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'User Deleted']);
    }
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id')->withDefault(['name' => 'Not Defined']);
    }
    public function leavestatus()
    {
        return $this->belongsTo(LeaveStatus::class)->withDefault(['name' => 'Pending', 'status' => 'Pending']);
    }

    
    public function leaveReason()
    {
        return $this->belongsTo(LeaveReason::class, 'leave_reason_id', 'id')->withDefault(['name' => 'Not defined']);
    }

    
	public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where(DB::raw('lower(note)'), 'like', '%'.strtolower($search).'%');
            //    $query->OrWhere(DB::raw('lower(start_date)'), 'like', '%'.strtolower($search).'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
