<?php

namespace App\Models;

use App\Enums\Gender;
use App\Traits\ActionByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, ActionByTrait, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'gender' =>  Gender::class,
    ];

    // relations
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function job()
    {
        return $this->belongsTo(EmployeeJob::class, 'job_id');
    }
}
