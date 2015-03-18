<?php

class UserControllerTest extends ExpendableTestCase {

    protected $controller = 'Admin\UserController';

    public function setUp()
    {
        parent::setUp();

        \Distilleries\Expendable\Models\Role::create([
            'libelle'            => 'admin',
            'initials'           => '@a',
            'overide_permission' => true,
        ]);

        \Distilleries\Expendable\Models\Service::create([
            'action' => 'test',
        ]);

        $faker = Faker\Factory::create();
        $email = $faker->email;
        $user  = \Distilleries\Expendable\Models\User::create([
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1,
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => 1,
            'service_id' => 1,
        ]);

        $this->be($user);

    }


    public function testDatatable()
    {

        $response = $this->call('GET', action($this->controller.'@getIndex'));
        $this->assertResponseOk();

        $this->assertContains('Id', $response->getContent());
        $this->assertContains('Email', $response->getContent());

    }

    public function testView()
    {
        $faker = Faker\Factory::create();

        $role = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => addslashes($faker->name),
            'initials'           => addslashes($faker->name),
            'overide_permission' => true,
        ]);

        $data = [
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ];


        $user = \Distilleries\Expendable\Models\User::create($data);

        $response = $this->call('GET', action($this->controller.'@getView', [
            'id' => $user->id
        ]));

        $this->assertResponseOk();
        $this->assertContains($data['email'], $response->getContent());
        $this->assertContains($role->libelle, $response->getContent());
    }

    public function testEdit()
    {
        $faker = Faker\Factory::create();

        $role = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ]);

        $data = [
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ];


        $user     = \Distilleries\Expendable\Models\User::create($data);
        $response = $this->call('GET', action($this->controller.'@getEdit', [
            'id' => $user->id
        ]));

        $this->assertResponseOk();
        $this->assertContains($data['email'], $response->getContent());

    }


    public function testSaveError()
    {
        $this->call('POST', action($this->controller.'@postEdit'));
        $this->assertSessionHasErrors();
        $this->assertHasOldInput();
    }

    public function testSave()
    {
        $faker = Faker\Factory::create();

        $role = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ]);

        $data = [
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ];

        $this->call('POST', action($this->controller.'@postEdit'), $data);
        $total = \Distilleries\Expendable\Models\User::where('email', $data['email'])->count();

        $this->assertEquals(1, $total);

    }


    public function testDestroyNoId()
    {

        $this->call('PUT', action($this->controller.'@putDestroy'));
        $this->assertSessionHasErrors();
        $this->assertHasOldInput();

    }

    public function testDestroy()
    {
        $faker = Faker\Factory::create();

        $role = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ]);

        $data = [
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ];
        $user = \Distilleries\Expendable\Models\User::create($data);

        $this->call('PUT', action($this->controller.'@putDestroy'), [
            'id' => $user->id
        ]);
        $newUser = \Distilleries\Expendable\Models\User::find($user->id);

        $this->assertEquals(null, $newUser);

    }

    public function testProfile()
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
            'email'    => addslashes($email),
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => $role->id,
            'service_id' => $service->id,
        ]);

        $this->be($user);

        $response = $this->call('GET', action($this->controller.'@getProfile'), [
            'auth' => $this->app->make('Illuminate\Auth\Guard')
        ]);

        $this->assertResponseOk();
        $this->assertContains($user->email, $response->getContent());
        $this->assertContains($role->libelle, $response->getContent());
    }

/*
    public function testSearchWithRole()
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
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => $role->id,
            'service_id' => $service->id,
        ]);

        $response = $this->call('POST', action($this->controller.'@postSearchWithRole',[
            'role' => $role->role_id,
        ]),[
            'ids'  => [$user->id]
        ]);

        $result = json_decode($response->getContent());
        $this->assertEquals($user->id, $result[0]->id);
        $this->assertEquals($user->libelle, $result[0]->libelle);

        $response = $this->call('POST', action($this->controller.'@postSearchWithRole'), [
            'ids'  => [$user->id],
            'role' => $faker->name,
        ]);

        $result = json_decode($response->getContent());
        $this->assertEquals(0, $result->total);
    }*/
}

