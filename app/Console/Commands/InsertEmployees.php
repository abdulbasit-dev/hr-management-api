<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class InsertEmployees extends Command
{
    protected $signature = "employees:create {count}";
    protected $description = "Insert employee’s data based on a given number with progress bar";

    public function handle()
    {
        $count = $this->argument('count');
        $bar = $this->output->createProgressBar($count); // Create a progress bar

        for ($i = 0; $i < $count; $i++) {
            // Insert employee data here
            $this->performInsertion();
            $bar->advance(); // Increment the progress bar
        }

        $bar->finish();
        $this->info('Employee data insertion complete.');
    }

    private function performInsertion()
    {
        // Logic to insert employee data
    }

}
