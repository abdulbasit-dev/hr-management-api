<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relations
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }
}
