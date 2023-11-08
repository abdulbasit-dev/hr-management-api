<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->delete();

        $faker = Factory::create();

        User::create([
            'name' =>  'admin',
            'email' =>  "admin@" . config("app.name") . ".co",
            'password' => "password",
            "email_verified_at" => now(),
        ])->assignRole("admin");

        // // create 10 users
        // foreach (range(1, 10) as $index) {
        //     User::create([
        //         'name' => $index == 1 ? 'admin' : $faker->name,
        //         'email' => $index == 1 ? "admin@tornet.co" : $faker->email,
        //         'password' => "password",
        //         "email_verified_at" => now(),
        //     ]);
        // }
    }
}
