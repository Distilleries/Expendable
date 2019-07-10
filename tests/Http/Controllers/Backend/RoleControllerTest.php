<?php

class RoleControllerTest extends ExpendableTestCase {

    protected $controller = 'Backend\RoleController';

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

        $this->assertContains(trans('expendable::datatable.id'), $response->getContent());
        $this->assertContains(trans('expendable::datatable.libelle'), $response->getContent());
        $this->assertContains(trans('expendable::datatable.initials'), $response->getContent());

    }

    public function testView()
    {
        $faker = Faker\Factory::create();
        $data  = [
            'libelle'            => str_replace('\'','',$faker->name),
            'initials'           => str_replace('\'','',$faker->name),
            'overide_permission' => true,
        ];

        $role = \Distilleries\Expendable\Models\Role::create($data);

        $response = $this->call('GET', action($this->controller.'@getView', [
            'id' => $role->id
        ]));

        $this->assertResponseOk();
        $this->assertContains($data['libelle'], $response->getContent());
        $this->assertContains($data['initials'], $response->getContent());
    }

    public function testEdit()
    {

        $faker = Faker\Factory::create();
        $data  = [
            'libelle'            => str_replace('\'','',$faker->name),
            'initials'           => str_replace('\'','',$faker->name),
            'overide_permission' => true,
        ];

        $role = \Distilleries\Expendable\Models\Role::create($data);

        $response = $this->call('GET', action($this->controller.'@getEdit', [
            'id' => $role->id
        ]));

        $this->assertResponseOk();
        $this->assertContains($data['libelle'], $response->getContent());
        $this->assertContains($data['initials'], $response->getContent());
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
        $data  = [
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ];


        $this->call('POST', action($this->controller.'@postEdit'), $data);
        $total = \Distilleries\Expendable\Models\Role::where('initials', $data['initials'])->where('libelle', $data['libelle'])->count();

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
        $data  = [
            'libelle'            => $faker->name,
            'initials'           => $faker->name,
            'overide_permission' => true,
        ];

        $role = \Distilleries\Expendable\Models\Role::create($data);
        $this->call('PUT', action($this->controller.'@putDestroy'), [
            'id' => $role->id
        ]);
        $newRole = \Distilleries\Expendable\Models\Role::find($role->id);

        $this->assertEquals(null, $newRole);

    }

}

