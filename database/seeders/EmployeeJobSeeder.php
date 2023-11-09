<?php

namespace Database\Seeders;

use App\Models\EmployeeJob;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeJobSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employee_jobs')->delete();

        $jobs = [
            'Founder',
            'CEO',
            'CTO',
            'COO',
            'CFO',
            'CMO',
            'CIO',
            'CSO',
            'VP',
            'Director',
            'Manager',
            'Engineer',
            'Staff',
            'Intern',
        ];

        foreach ($jobs as $job) {
            EmployeeJob::create([
                'name' => $job,
            ]);
        }
    }
}
