<?php

namespace App\Console\Commands;

use App\Models\EmployeeLog;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class DeleteEmployeeLogs extends Command
{
    protected $signature = "logs:delete";
    protected $description = 'Delete logs older than 1 month from the employee logs table';

    public function handle()
    {
        $oneMonthAgo = now()->subMonth(); // Calculate a date one month ago
        EmployeeLog::where('created_at', '<', $oneMonthAgo)->delete();

        $this->info('Logs older than 1 month have been deleted.');
    }
}
