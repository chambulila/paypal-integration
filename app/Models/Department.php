<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = "departments";
    protected $fillable = [
        'id', 'name', 'created_at', 'updated_at', 'code'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
