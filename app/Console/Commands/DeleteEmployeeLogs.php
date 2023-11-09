<?php

namespace App\Console\Commands;

use App\Models\EmployeeLog;
use Illuminate\Console\Command;

class DeleteEmployeeLogs extends Command
{
    protected $signature = "logs:delete";
    protected $description = 'Delete logs older than 1 month from the employee logs table';

    public function handle()
    {
        // delete logs older than 1 month
        $count = EmployeeLog::where('created_at', '<', now()->subMonth())->delete();

        $this->info('Logs older than 1 month have been deleted. ' . $count . ' logs deleted.');
    }
}
