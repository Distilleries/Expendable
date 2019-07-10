<?php

class ServiceControllerTest extends ExpendableTestCase {

    protected $controller = 'Backend\ServiceController';

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
        $this->assertContains(trans('expendable::datatable.action'), $response->getContent());

    }

    public function testView()
    {
        $faker = Faker\Factory::create();
        $data  = [
            'action'            => str_replace('\'','',$faker->name)
        ];

        $service = \Distilleries\Expendable\Models\Service::create($data);

        $response = $this->call('GET', action($this->controller.'@getView', [
            'id' => $service->id
        ]));

        $this->assertResponseOk();
        $this->assertContains($data['action'], $response->getContent());
    }

    public function testEdit()
    {

        $faker = Faker\Factory::create();
        $data  = [
            'action'            => str_replace('\'','',$faker->name)
        ];

        $service = \Distilleries\Expendable\Models\Service::create($data);


        $response = $this->call('GET', action($this->controller.'@getEdit', [
            'id' => $service->id
        ]));

        $this->assertResponseOk();
        $this->assertContains($data['action'], $response->getContent());
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
            'action'            => $faker->name
        ];


        $this->call('POST', action($this->controller.'@postEdit'), $data);
        $total = \Distilleries\Expendable\Models\Service::where('action', $data['action'])->count();

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
            'action'            => $faker->name
        ];


        $service = \Distilleries\Expendable\Models\Service::create($data);
        $this->call('PUT', action($this->controller.'@putDestroy'), [
            'id' => $service->id
        ]);
        $newService = \Distilleries\Expendable\Models\Service::find($service->id);

        $this->assertEquals(null, $newService);

    }

    public function testSynchronise(){

        \DB::table('services')->truncate();
        $this->call('GET', action($this->controller.'@getSynchronize'),[
            'router'=>$this->app->make('Illuminate\Contracts\Routing\Registrar')
        ]);

        $this->assertTrue(\Distilleries\Expendable\Models\Service::count() > 0);
    }

}

