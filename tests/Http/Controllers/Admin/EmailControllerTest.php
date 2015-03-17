<?php

class EmailControllerTest extends ExpendableTestCase {

    protected $controller = 'Admin\EmailController';

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../../../../vendor/distilleries/mailersaver/src/database/migrations'),
        ]);

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

        $this->assertContains(trans('expendable::datatable.subject'), $response->getContent());
        $this->assertContains(trans('expendable::datatable.type'), $response->getContent());
        $this->assertContains('Cc', $response->getContent());
        $this->assertContains('Bcc', $response->getContent());

    }

    public function testView()
    {
        $faker = Faker\Factory::create();
        $data  = [
            'libelle'   => addslashes($faker->realText(20)),
            'body_type' => \Distilleries\Expendable\Helpers\StaticLabel::BODY_TYPE_HTML,
            'action'    => 'emails.password',
            'cc'        => $faker->email,
            'bcc'       => $faker->email,
            'content'   => addslashes($faker->text()),
            'status'    => \Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE,
        ];

        $email = \Distilleries\Expendable\Models\Email::create($data);

        $response = $this->call('GET', action($this->controller.'@getView', [
            'id' => $email->id
        ]));

        $this->assertResponseOk();
        $this->assertContains($data['libelle'], $response->getContent());
        $this->assertContains($data['body_type'], $response->getContent());
        $this->assertContains($data['action'], $response->getContent());
        $this->assertContains($data['cc'], $response->getContent());
        $this->assertContains($data['bcc'], $response->getContent());
        $this->assertContains($data['content'], $response->getContent());
    }

    public function testEdit()
    {
        $faker = Faker\Factory::create();
        $data  = [
            'libelle'   => addslashes($faker->name),
            'body_type' => \Distilleries\Expendable\Helpers\StaticLabel::BODY_TYPE_HTML,
            'action'    => 'emails.password',
            'cc'        => $faker->email,
            'bcc'       => $faker->email,
            'content'   => addslashes($faker->name()),
            'status'    => \Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE,
        ];

        $email = \Distilleries\Expendable\Models\Email::create($data);

        $response = $this->call('GET', action($this->controller.'@getEdit', [
            'id' => $email->id
        ]));

        $this->assertResponseOk();
        $this->assertContains($data['libelle'], $response->getContent());
        $this->assertContains($data['body_type'], $response->getContent());
        $this->assertContains($data['action'], $response->getContent());
        $this->assertContains($data['content'], $response->getContent());

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
            'libelle'   => addslashes($faker->realText(20)),
            'body_type' => \Distilleries\Expendable\Helpers\StaticLabel::BODY_TYPE_HTML,
            'action'    => 'emails.password',
            'cc'        => $faker->email,
            'bcc'       => $faker->email,
            'content'   => addslashes($faker->text()),
            'status'    => \Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE,
        ];


        $this->call('POST', action($this->controller.'@postEdit'), $data);
        $total = \Distilleries\Expendable\Models\Email::where('libelle', $data['libelle'])->where('action', $data['action'])->count();

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
            'libelle'   => addslashes($faker->realText(20)),
            'body_type' => \Distilleries\Expendable\Helpers\StaticLabel::BODY_TYPE_HTML,
            'action'    => 'emails.password',
            'cc'        => $faker->email,
            'bcc'       => $faker->email,
            'content'   => addslashes($faker->text()),
            'status'    => \Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE,
        ];

        $email = \Distilleries\Expendable\Models\Email::create($data);
        $this->call('PUT', action($this->controller.'@putDestroy'), [
            'id' => $email->id
        ]);
        $newEmail = \Distilleries\Expendable\Models\Email::find($email->id);

        $this->assertEquals(null, $newEmail);

    }

}

