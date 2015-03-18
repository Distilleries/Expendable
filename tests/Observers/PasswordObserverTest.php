<?php

class PasswordObserverTest extends ExpendableTestCase {

    public function testAddWithPreHash()
    {

        $faker = Faker\Factory::create();
        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1,
        ]);

        $this->assertTrue(\Hash::check('test', $user->password));
    }

    public function testAddNoHash()
    {

        $faker = Faker\Factory::create();
        \Distilleries\Expendable\Models\User::observe(new \Distilleries\Expendable\Observers\PasswordObserver);
        $user = new \Distilleries\Expendable\Models\User;

        $user->email    = $faker->email;
        $user->password = 'test';
        $user->status   = true;
        $user->role_id  = 1;

        $user->save();

        $this->assertTrue(\Hash::check('test', $user->password));
    }

    public function testUpdateWithPreHash()
    {

        $faker = Faker\Factory::create();
        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1,
        ]);
        \Distilleries\Expendable\Models\User::observe(new \Distilleries\Expendable\Observers\PasswordObserver);
        $user = \Distilleries\Expendable\Models\User::find($user->id);

        \Request::replace([
            'password' => \Hash::make('newpassword')
        ]);

        $user->update([
            'name'     => $faker->name,
            'password' => \Hash::make('newpassword')
        ]);

        $this->assertTrue(\Hash::check('newpassword', $user->password));
    }


    public function testUpdateNoHash()
    {

        $faker = Faker\Factory::create();
        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1,
        ]);

        \Distilleries\Expendable\Models\User::observe(new \Distilleries\Expendable\Observers\PasswordObserver);
        $user = \Distilleries\Expendable\Models\User::find($user->id);
        \Request::replace([
            'password' => 'newpassword'
        ]);

        $user->update([
            'name'     => $faker->name,
            'password' => 'newpassword'
        ]);

        $this->assertTrue(\Hash::check('newpassword', $user->password));
    }

    public function testUpdateNoHashNoRequestNoNewPassword()
    {

        $faker = Faker\Factory::create();
        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1,
        ]);

        \Distilleries\Expendable\Models\User::observe(new \Distilleries\Expendable\Observers\PasswordObserver);
        $user = \Distilleries\Expendable\Models\User::find($user->id);

        $user->update([
            'name'     => $faker->name,
            'password' => ''
        ]);

        $this->assertTrue(\Hash::check('test', $user->password));
    }


    public function testUpdateNoHashNoRequesWithNewPassword()
    {

        $faker = Faker\Factory::create();
        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1,
        ]);

        \Distilleries\Expendable\Models\User::observe(new \Distilleries\Expendable\Observers\PasswordObserver);
        $user = \Distilleries\Expendable\Models\User::find($user->id);

        $user->update([
            'name'     => $faker->name,
            'password' => 'newpassword'
        ]);

        $this->assertTrue(\Hash::check('newpassword', $user->password));
    }

}

