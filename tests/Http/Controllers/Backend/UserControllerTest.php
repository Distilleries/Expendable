<?php

class UserControllerTest extends ExpendableTestCase {

    protected $controller = 'Backend\UserController';

    public function setUp(): void
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


    public function testDatatableApi()
    {


        $faker = Faker\Factory::create();

        $role = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => str_replace('\'', '', $faker->name),
            'initials'           => str_replace('\'', '', $faker->name),
            'overide_permission' => true,
        ]);

        $data = [
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ];


        $user = \Distilleries\Expendable\Models\User::create($data);

        $response = $this->call('GET', action($this->controller.'@getDatatable'));
        $this->assertResponseOk();
        $result = json_decode($response->getContent());

        $this->assertEquals(2, $result->iTotalRecords);
        $this->assertEquals($user->id, $result->aaData[1]->{0});
        $this->assertEquals($user->email, $result->aaData[1]->{1});
    }

    public function testDatatableApiNoSuperAdmin()
    {


        $faker = Faker\Factory::create();

        $role       = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => str_replace('\'', '', $faker->name),
            'initials'           => str_replace('\'', '', $faker->name),
            'overide_permission' => true,
        ]);
        $superadmin = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => str_replace('\'', '', $faker->name),
            'initials'           => '@sa',
            'overide_permission' => true,
        ]);

        $data = [
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ];


        $user = \Distilleries\Expendable\Models\User::create($data);

        \Distilleries\Expendable\Models\User::create([
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $superadmin->id,
        ]);

        $response = $this->call('GET', action($this->controller.'@getDatatable'));
        $this->assertResponseOk();
        $result = json_decode($response->getContent());

        $this->assertEquals(2, $result->iTotalRecords);
        $this->assertEquals($user->id, $result->aaData[1]->{0});
        $this->assertEquals($user->email, $result->aaData[1]->{1});
    }


    public function testView()
    {
        $faker = Faker\Factory::create();

        $role = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => str_replace('\'', '', $faker->name),
            'initials'           => str_replace('\'', '', $faker->name),
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
            'email'    => str_replace("'","",$faker->email),
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
            'email'    => str_replace("'","",$faker->email),
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
            'email'    => str_replace("'","",$faker->email),
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

        $response = $this->call('GET', action($this->controller.'@getProfile'));

        $this->assertResponseOk();
        $this->assertContains($user->email, $response->getContent());
        $this->assertContains($role->libelle, $response->getContent());
    }


    public function testSaveProfile()
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

        $response = $this->call('POST', action($this->controller.'@postProfile'), [
            'id'    => $user->id,
            'email' => str_replace('\'', '', $faker->email)
        ]);

        $this->assertResponseOk();
        $this->assertContains($user->email, $response->getContent());
        $this->assertContains($role->libelle, $response->getContent());
    }


    public function testSaveProfileNotAuthorize()
    {
        $this->disableExceptionHandling();

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

        $userOther           = \Distilleries\Expendable\Models\User::create([
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ]);

        try
        {
            $response = $this->call('POST', action($this->controller.'@postProfile'), [
                'id'    => $userOther->id,
                'email' => str_replace('\'', '', $faker->email)
            ]);

            $this->assertEquals(403,$response->getStatusCode());
            
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e)
        {
            $this->assertEquals(trans('permission-util::errors.unthorized'), $e->getMessage());
        }

    }


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

        $response = $this->call('POST', action($this->controller.'@postSearchWithRole'), [
            'ids'  => [$user->id],
            'role' => $role->id,
        ]);

        $result = json_decode($response->getContent());
        $this->assertEquals($user->id, $result[0]->id);
        $this->assertEquals($user->email, $result[0]->email);


        $response = $this->call('POST', action($this->controller.'@postSearchWithRole'), [
            'ids'  => [$user->id],
            'role' => - 1,
        ]);

        $result = json_decode($response->getContent());
        $this->assertEquals(0, count($result));
    }
}

