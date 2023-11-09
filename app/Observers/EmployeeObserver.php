<?php

namespace App\Observers;

use App\Mail\SalaryChanged;
use App\Models\Employee;
use App\Models\EmployeeLog;
use App\Services\EmployeeLogService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmployeeObserver
{
    public function created(Employee $employee)
    {
        EmployeeLogService::logEmployeeAction($employee, "Created");

        Log::info("Employee created " . $employee->name);
    }

    public function updating(Employee $employee)
    {
        Log::info("Employee updating " . $employee->name);
    }

    public function updated(Employee $employee)
    {
        // send email if salary changed
        if ($employee->wasChanged('salary')) {
            Mail::to($employee->email)->send(new SalaryChanged($employee, $employee->getOriginal('salary')));
        }

        EmployeeLogService::logEmployeeAction($employee, "Updated");
        Log::info("Employee updated " . $employee->name);
    }

    public function deleted(Employee $employee)
    {
        EmployeeLogService::logEmployeeAction($employee, "Deleted");
        Log::info("Employee deleted " . $employee->name);
    }

    public function restored(Employee $employee)
    {

        EmployeeLogService::logEmployeeAction($employee, "Restored");
        Log::info("Employee restored " . $employee->name);
    }

    public function forceDeleted(Employee $employee)
    {

        EmployeeLogService::logEmployeeAction($employee, "ForceDeleted");
        Log::info("Employee forceDeleted " . $employee->name);
    }
}
