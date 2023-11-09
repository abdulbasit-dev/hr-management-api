<?php

namespace App\Observers;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class EmployeeObserver
{

    public function created(Employee $employee)
    {
        Log::info("Employee created ". $employee->name);
    }

    public function updated(Employee $employee)
    {
        //
    }

    public function deleted(Employee $employee)
    {
        //
    }

    public function restored(Employee $employee)
    {
        //
    }

    public function forceDeleted(Employee $employee)
    {
        //
    }
}
