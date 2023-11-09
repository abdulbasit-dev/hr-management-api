<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeLog;

class EmployeeLogService
{
    public static function logEmployeeAction(Employee $employee, string $action)
    {
        EmployeeLog::create([
            "employee_id" => $employee->id,
            "action" => $action,
            "action_by" => auth()->id(),
        ]);
    }
}
