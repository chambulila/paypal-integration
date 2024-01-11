<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'name',
        'user',
        'description',
        'status'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where(DB::raw('lower(name)'), 'like', '%'.strtolower($search).'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
