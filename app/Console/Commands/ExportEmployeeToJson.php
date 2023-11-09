<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;

class ExportEmployeeToJson extends Command
{
    protected $signature = "employees:export";
    protected $description = "Export employee’s data to json file";


    public function handle()
    {
        $employees = Employee::all();
        $json = $employees->toJson(JSON_PRETTY_PRINT);

        $filename = 'employees_' . now()->format('Y-m-d_H-i-s') . '.json';
        file_put_contents(storage_path('app/exports/' . $filename), $json);

        $this->info('Employees exported to location ' . storage_path('app/exports/' . $filename));
    }
}
