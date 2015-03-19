<?php

class LoginControllerTest extends ExpendableTestCase {

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../../../../vendor/distilleries/mailersaver/src/database/migrations'),
        ]);


    }

    public function testRedirectNotLogin()
    {
        $this->call('GET', '/admin');
        $this->assertRedirectedToRoute('login.index');
    }

    public function testRedirectLogin()
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

        $this->call('GET', '/admin');
        $this->assertRedirectedToAction('Admin\EmailController@getIndex');
    }

    public function testGetIndex()
    {

        $response = $this->call('GET', action('Admin\LoginController@getIndex'));
        $this->assertResponseOk();

        $this->assertContains(trans('expendable::form.email'), $response->getContent());
        $this->assertContains(trans('expendable::form.password'), $response->getContent());

    }

    public function testLoginEmpty()
    {
        $this->call('POST', action('Admin\LoginController@postIndex'), [
            'email'    => '',
            'password' => '',
        ]);
        $this->assertSessionHasErrors(['email', 'password']);
    }

    public function testBadCredential()
    {

        $faker = Faker\Factory::create();


        $this->call('POST', action('Admin\LoginController@postIndex'), [
            'email'    => $faker->email,
            'password' => 'test',
        ]);

        $this->assertSessionHas(\Distilleries\Expendable\Formatter\Message::WARNING);

    }


    public function testLoginLogout()
    {

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


        $this->call('POST', action('Admin\LoginController@postIndex'), [
            'email'    => $email,
            'password' => 'test',
        ]);

        $newUser = $this->app->make('Illuminate\Contracts\Auth\Guard')->user();
        $this->assertEquals($user->id, $newUser->id);

        $this->call('GET', action('Admin\LoginController@getLogout'));
        $newUser = $this->app->make('Illuminate\Contracts\Auth\Guard')->user();
        $this->assertEquals(null, $newUser);
    }


    public function testGetReminder()
    {

        $response = $this->call('GET', action('Admin\LoginController@getRemind'));
        $this->assertResponseOk();

        $this->assertContains(trans('expendable::form.email'), $response->getContent());

    }

    public function testReminderEmpty()
    {
        $this->call('POST', action('Admin\LoginController@postRemind'), [
            'email' => '',
        ]);
        $this->assertSessionHasErrors(['email']);
    }


    public function testBadReminder()
    {
        $faker    = Faker\Factory::create();
        $response = $this->call('POST', action('Admin\LoginController@postRemind'), [
            'email' => $faker->email.rand()
        ]);

        $this->assertSessionHas(\Distilleries\Expendable\Formatter\Message::WARNING);

    }

    public function testPostReminder()
    {

        $this->app->make('Illuminate\Contracts\Config\Repository')->set('mail.from', ['address' => 'maxime@verdikt.com.au', 'name' => 'maxime@verdikt.com.au']);
        $this->app->make('Illuminate\Contracts\Config\Repository')->set('mail.pretend', true);

        $faker = Faker\Factory::create();
        $data  = [
            'libelle'   => $faker->realText(20),
            'body_type' => \Distilleries\Expendable\Helpers\StaticLabel::BODY_TYPE_HTML,
            'action'    => 'emails.password',
            'cc'        => $faker->email,
            'bcc'       => $faker->email,
            'content'   => $faker->text(),
            'status'    => \Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE,
        ];


        \Distilleries\Expendable\Models\Email::create($data);

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


        $response = $this->call('POST', action('Admin\LoginController@postRemind'), [
            'email' => $email
        ]);
        $this->assertSessionHas(\Distilleries\Expendable\Formatter\Message::MESSAGE);


    }


    public function testGetResetNoToken()
    {
        try
        {
            $this->call('GET', action('Admin\LoginController@getReset'));
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e)
        {
            $this->assertTrue(true);
        }
    }

    public function testGetResetToken()
    {
        $response = $this->call('GET', action('Admin\LoginController@getReset', [
            'token' => 'bEJa3ysNqVCOv4SkGkcrJnJWqAOmh93UZrmv1IM171zAJ82WylyXh7c4CRHW'
        ]));

        $this->assertResponseOk();

        $this->assertContains('name="token"', $response->getContent());
        $this->assertContains(trans('expendable::form.email'), $response->getContent());
        $this->assertContains(trans('expendable::form.password'), $response->getContent());
        $this->assertContains(trans('expendable::form.repeat_password'), $response->getContent());
        $this->assertContains(trans('expendable::form.send'), $response->getContent());

    }

    public function testPostResetNoToeken()
    {

        $this->call('POST', action('Admin\LoginController@postReset'), [
        ]);

        $this->assertSessionHasErrors();
        $this->assertHasOldInput();
    }

    public function testPostResetInvalid()
    {

        $faker = Faker\Factory::create();
        $this->call('POST', action('Admin\LoginController@postReset'), [
            'token'                 => 'bEJa3ysNqVCOv4SkGkcrJnJWqAOmh93UZrmv1IM171zAJ82WylyXh7c4CRHW',
            'email'                 => $faker->email,
            'password'              => $faker->email,
            'password_confirmation' => $faker->email,
        ]);

        $this->assertSessionHas('error');
    }


    public function testPostResetValid()
    {

        $token = 'bEJa3ysNqVCOv4SkGkcrJnJWqAOmh93UZrmv1IM171zAJ82WylyXh7c4CRHW';
        $faker = Faker\Factory::create();

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
            'role_id'  => 1
        ]);

        \DB::table('password_resets')->insert(
            array('email' => $email, 'token' => $token, 'created_at' => date('Y-m-d H:i:s'))
        );

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => 1,
            'service_id' => 1,
        ]);


        $this->call('POST', action('Admin\LoginController@postReset'), [
            'token'                 => $token,
            'email'                 => $email,
            'password'              => 'testtesttesttest',
            'password_confirmation' => 'testtesttesttest',
        ]);

        $this->assertRedirectedToAction('Admin\LoginController@getIndex');


    }

}

