<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Distilleries\Expendable\Models\User;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index)
        {
            User::create([
                'email'    => $faker->email,
                'password' => \Hash::make('test'),
                'status'   => true,
                'role_id'  => 1,
            ]);
        }
    }
}