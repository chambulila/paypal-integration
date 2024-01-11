<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'task_id',
        'quantity',
        'currency',
        'method',
        'payer',
        'status'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id')->withDefault('name', 'Not Defined');
    }
}
