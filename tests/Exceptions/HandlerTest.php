<?php

class HandlerTest extends ExpendableTestCase {

    protected function resolveApplicationExceptionHandler($app)
    {
        $app->singleton('Illuminate\Contracts\Debug\ExceptionHandler', 'Distilleries\Expendable\Exceptions\Handler');
    }

    public function testExceptionAdmin()
    {
        $faker = Faker\Factory::create();
        $role  = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ]);


        $service = \Distilleries\Expendable\Models\Service::create([
            'action' => $faker->name,
        ]);


        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => str_replace('\'', '', $email),
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => $role->id,
            'service_id' => $service->id,
        ]);

        $this->app->make('config')->set('app.debug',true);
        $this->be($user);
        $response = $this->call('GET', '/test');
        $this->assertEquals(404,$response->getStatusCode());
        $this->assertNotContains('page-404',$response->getContent());
        $this->assertContains('404',$response->getContent());
        $this->assertContains('Not Found',$response->getContent());
    }



    public function testExceptionAdminNoDebug()
    {
        $faker = Faker\Factory::create();
        $role  = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ]);


        $service = \Distilleries\Expendable\Models\Service::create([
            'action' => $faker->name,
        ]);


        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => str_replace('\'', '', $email),
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => $role->id,
            'service_id' => $service->id,
        ]);

        $this->be($user);
        $this->app->make('config')->set('app.debug',false);

        $response = $this->call('GET', '/admin/test');
        $this->assertEquals(404,$response->getStatusCode());
        $this->assertContains('page-404',$response->getContent());
    }


    public function testExceptionNoCatche()
    {
        $faker = Faker\Factory::create();
        $role  = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ]);


        $service = \Distilleries\Expendable\Models\Service::create([
            'action' => $faker->name,
        ]);


        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => str_replace('\'', '', $email),
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => $role->id,
            'service_id' => $service->id,
        ]);

        $this->be($user);
        $response = $this->call('GET', '/test');
        $this->assertEquals(404,$response->getStatusCode());
        $this->assertNotContains('page-404',$response->getContent());
        $this->assertContains('404',$response->getContent());
        $this->assertContains('Not Found',$response->getContent());
    }





}