<?php

namespace App\Console\Commands;

use App\Enums\Gender;
use App\Models\Employee;
use App\Models\EmployeeJob;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateEmployees extends Command
{
    protected $signature = "employees:create {count}";
    protected $description = "Insert employee’s data based on a given number with progress bar";

    public function handle()
    {
        // check if the count is a number
        $validator = Validator::make(['count' => $this->argument('count')], [
            'count' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            $this->error('The count must be a number greater than 0.');
            return;
        }

        $count = $this->argument('count') ;

        // start inserting employee data log
        $this->info("Inserting ${count} Employee data...");

        $bar = $this->output->createProgressBar($count); // Create a progress bar

        for ($i = 0; $i < $count; $i++) {
            // Insert employee data here
            $this->performInsertion();
            $bar->advance(); // Increment the progress bar
        }

        $bar->finish();
        $this->line("");
        $this->info("Employee data insertion complete.");
    }

    private function performInsertion()
    {
        // Logic to insert employee data
        $faker = Factory::create();
        Employee::create([
            "job_id" => EmployeeJob::inRandomOrder()->first()->id,
            "name"  => $faker->name(),
            "email" => $faker->email(),
            "age" => $faker->numberBetween(18, 60),
            "hire_date" => $faker->date(),
            "salary"    => rand(1000, 2000),
            "gender" => array_rand(array_column(Gender::cases(), 'value')),
        ]);
    }

}
