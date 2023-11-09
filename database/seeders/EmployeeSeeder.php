<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeJob;
use App\Enums\Gender;
use Faker\Factory;
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
            "job_id"     => EmployeeJob::whereName("Founder")->value("id"),
            "name"       => "Dr. Anibal D'Amore",
            "email"      => "anibal@tornet.co",
            "age"        => 46,
            "hire_date"  => $faker->date(),
            "salary"     => "3000",
            "gender"     => Gender::MALE,
            "is_founder" => true,
        ]);

        // create 100 employees
        foreach (range(1, 50) as $index) {
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
}
