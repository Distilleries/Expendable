<?php

class ComponentControllerTest extends ExpendableTestCase {

    protected $controller = 'Admin\ComponentController';

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


    public function testIndex()
    {

        $this->call('GET', action($this->controller.'@getIndex'));
        $this->assertRedirectedToAction($this->controller.'@getEdit');
    }

    public function testEdit()
    {

        $response = $this->call('GET', action($this->controller.'@getEdit'));

        $this->assertResponseOk();
        $this->assertContains(trans('expendable::form.name'), $response->getContent());
        $this->assertContains(trans('expendable::form.auto_sufix'), $response->getContent());
        $this->assertContains(trans('expendable::form.state'), $response->getContent());
        $this->assertContains(trans('expendable::form.model'), $response->getContent());
        $this->assertContains(trans('expendable::form.help_colon_datatable'), $response->getContent());
        $this->assertContains(trans('expendable::form.help_fields_form'), $response->getContent());

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

        $data = [
            'libelle'         => $faker->word,
            'state'           => [
                'Distilleries\DatatableBuilder\Contracts\DatatableStateContract',
                'Distilleries\Expendable\Contracts\ExportStateContract',
                'Distilleries\Expendable\Contracts\ImportStateContract',
                'Distilleries\FormBuilder\Contracts\FormStateContract',
            ],
            'models'          => 'Distilleries\Expendable\Models\User',
            'colon_datatable' => 'id,email',
            'fields_form'     => 'id:hidden,email:email',
        ];

        $this->call('POST', action($this->controller.'@postEdit'), $data);
        $this->assertFileExists(app_path('Datatables/'.$data['libelle'].'Datatable.php'));
        $this->assertFileExists(app_path('Forms/'.$data['libelle'].'Form.php'));
        $this->assertFileExists(app_path('Http/Controllers/Admin/'.$data['libelle'].'Controller.php'));

        $this->assertSessionHas(\Distilleries\Expendable\Formatter\Message::MESSAGE);

    }

}

