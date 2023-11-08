<?php

namespace Database\Seeders;

use App\Models\Employee;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table("employees")->delete();

        $faker = Factory::create();

        // founder
        Employee::create([
            "name"       => "Dr. Anibal D'Amore ",
            "email"      => "anibal@tornet.co",
            "age"        => 46,
            "hire_date"  => $faker->date(),
            "salary"     => "4000000",
            "gender"     => "Male",
            "job_title"  => "Founder",
            "is_founder" => true,
        ]);

        // create 100 employees
        foreach (range(1, 100) as $index) {
            Employee::create([
                "name"  => $faker->name(),
                "email" => $faker->email(),
                "age" => $faker->numberBetween(18, 60),
                "hire_date" => $faker->date(),
                "salary"    => rand(1, 11111111),
                "gender"   => $faker->randomElement(["Male", "Female", "Other"]),
                "job_title" => $faker->jobTitle()
            ]);
        }
    }
}
