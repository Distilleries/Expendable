<?php

class PermissionControllerTest extends ExpendableTestCase {

    protected $controller = 'Backend\PermissionController';

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


    public function testIndex()
    {
        $this->call('GET', action($this->controller.'@getIndex'));
        $this->assertRedirectedToAction($this->controller.'@getEdit');
    }

    public function testEdit()
    {
        $this->call('GET', action($this->controller.'@getEdit'));
        $this->assertResponseOk();
    }


    public function testSave()
    {
        $faker = Faker\Factory::create();

        $role = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ]);

        $service = \Distilleries\Expendable\Models\Service::create([
            'action' => $faker->name,
        ]);


        $data = [
            $role->id=>[
                $service->id
            ]
        ];


        $this->call('POST', action($this->controller.'@postEdit'), ['permission'=>$data]);
        $total = \Distilleries\Expendable\Models\Permission::where('role_id', $role->id)->where('service_id', $service->id)->count();

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

        $service = \Distilleries\Expendable\Models\Service::create([
            'action' => $faker->name,
        ]);

        $permission = \Distilleries\Expendable\Models\Permission::create([
            'role_id'=>$role->id,
            'service_id'=>$service->id,
        ]);

        $this->call('PUT', action($this->controller.'@putDestroy'), [
            'id' => $permission->id
        ]);
        $newService = \Distilleries\Expendable\Models\Permission::find($permission->id);

        $this->assertEquals(null, $newService);

    }
}

