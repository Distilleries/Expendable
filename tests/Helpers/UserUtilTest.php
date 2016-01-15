<?php

class UserUtilTest extends ExpendableTestCase {

    protected function login()
    {
        $role = \Distilleries\Expendable\Models\Role::get()->last();

        if (empty($role))
        {
            \Distilleries\Expendable\Models\Role::create([
                'libelle'            => 'admin',
                'initials'           => '@a',
                'overide_permission' => false,
            ]);
        }

        $faker = Faker\Factory::create();
        $email = $faker->email;


        $user = \Distilleries\Expendable\Models\User::create([
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1,
        ]);

        $this->app->make('Illuminate\Contracts\Auth\Guard')->login($user);
        return $email;

    }

    public function testUserUtilGet()
    {
        $user = \Distilleries\Expendable\Helpers\UserUtils::get();
        $this->assertEquals(null, $user);
        $this->login();
        $user  = \Distilleries\Expendable\Helpers\UserUtils::get();
        $this->assertInstanceOf('Distilleries\Expendable\Models\User', $user);
    }

    public function testGetEmail()
    {
        $email = $this->login();
        $this->assertEquals($email, \Distilleries\Expendable\Helpers\UserUtils::getEmail());
    }

    public function testGetDisplayName()
    {
        $email = $this->login();
        $this->assertEquals($email, \Distilleries\Expendable\Helpers\UserUtils::getDisplayName());
    }

    public function testIsNotSuperAdmin()
    {
        $this->login();
        $this->assertTrue(\Distilleries\Expendable\Helpers\UserUtils::isNotSuperAdmin());
    }
    public function testGetArea()
    {
        $this->login();
        \Distilleries\Expendable\Helpers\UserUtils::setArea([]);
        $this->assertTrue(is_array(\Distilleries\Expendable\Helpers\UserUtils::getArea()));
    }
    public function testHasAccess()
    {
        $this->login();
        \Distilleries\Expendable\Helpers\UserUtils::setArea(['test_action']);
        $this->assertTrue(\Distilleries\Expendable\Helpers\UserUtils::hasAccess('test_action'));
        $this->assertFalse(\Distilleries\Expendable\Helpers\UserUtils::hasAccess('test_action_not_in'));
    }


}