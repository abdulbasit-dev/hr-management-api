<?php

namespace App\Models;

use App\Traits\ActionByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeJob extends Model
{
    use HasFactory, ActionByTrait, SoftDeletes;

    protected $guarded = [];

    // relations
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
