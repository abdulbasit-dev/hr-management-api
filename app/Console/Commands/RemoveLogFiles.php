<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class RemoveLogFiles extends Command
{
    protected $signature = "logs:remove";
    protected $description = 'Remove all log files';

    public function handle()
    {
        $files = glob(storage_path('logs/*')); // Get all files in the logs directory

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete the file
            }
        }

        $this->info('All log files have been removed.');
    }
}
