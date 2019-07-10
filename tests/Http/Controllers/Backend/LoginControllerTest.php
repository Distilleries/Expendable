<?php

class LoginControllerTest extends ExpendableTestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');


    }

    public function testRedirectNotLogin()
    {
        $this->call('GET', '/admin');
        $this->assertRedirectedToRoute('login');
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
        $this->assertRedirectedToAction('Backend\UserController@getIndex');
    }

    public function testGetIndex()
    {

        $response = $this->call('GET', action('Backend\LoginController@getIndex'));
        $this->assertResponseOk();

        $this->assertContains(trans('expendable::form.email'), $response->getContent());
        $this->assertContains(trans('expendable::form.password'), $response->getContent());

    }

    public function testLoginEmpty()
    {
        $this->call('POST', action('Backend\LoginController@postIndex'), [
            'email'    => '',
            'password' => '',
        ]);
        $this->assertSessionHasErrors(['email', 'password']);
    }

    public function testBadCredential()
    {

        $faker = Faker\Factory::create();


        $this->call('POST', action('Backend\LoginController@postIndex'), [
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


        $this->call('POST', action('Backend\LoginController@postIndex'), [
            'email'    => $email,
            'password' => 'test',
        ]);

        $newUser = $this->app->make('Illuminate\Contracts\Auth\Guard')->user();
        $this->assertEquals($user->id, $newUser->id);

        $this->call('GET', action('Backend\LoginController@getLogout'));
        $newUser = $this->app->make('Illuminate\Contracts\Auth\Guard')->user();
        $this->assertEquals(null, $newUser);
    }


    public function testGetReminder()
    {

        $response = $this->call('GET', action('Backend\LoginController@getRemind'));
        $this->assertResponseOk();

        $this->assertContains(trans('expendable::form.email'), $response->getContent());

    }

    public function testReminderEmpty()
    {
        $this->call('POST', action('Backend\LoginController@postRemind'), [
            'email' => '',
        ]);
        $this->assertSessionHasErrors(['email']);
    }


    public function testBadReminder()
    {
        $faker    = Faker\Factory::create();
        $response = $this->call('POST', action('Backend\LoginController@postRemind'), [
            'email' => $faker->email . rand()
        ]);


        $this->assertSessionHas(\Distilleries\Expendable\Formatter\Message::WARNING);

    }

    public function testPostReminder()
    {

        $this->app->make('Illuminate\Contracts\Config\Repository')->set('mail.from', ['address' => 'maxime@verdikt.com.au', 'name' => 'maxime@verdikt.com.au']);
        $this->app->make('Illuminate\Contracts\Config\Repository')->set('mail.pretend', true);

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

        $response = $this->call('POST', action('Backend\LoginController@postRemind'), [
            'email' => $email
        ]);

        $this->assertSessionHas(\Distilleries\Expendable\Formatter\Message::MESSAGE);


    }


    public function testGetResetNoToken()
    {
        $this->disableExceptionHandling();

        try {
            $this->call('GET', action('Backend\LoginController@getReset'));
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            $this->assertTrue(true);
        }
    }

    public function testGetResetToken()
    {
        $response = $this->call('GET', action('Backend\LoginController@getReset', [
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

        $this->call('POST', action('Backend\LoginController@postReset'), [
        ]);

        $this->assertSessionHasErrors();
        $this->assertHasOldInput();
    }

    public function testPostResetInvalid()
    {

        $faker = Faker\Factory::create();
        $this->call('POST', action('Backend\LoginController@postReset'), [
            'token'                 => 'bEJa3ysNqVCOv4SkGkcrJnJWqAOmh93UZrmv1IM171zAJ82WylyXh7c4CRHW',
            'email'                 => $faker->email,
            'password'              => $faker->email,
            'password_confirmation' => $faker->email,
        ]);

        $this->assertSessionHas('error');
    }

/*
    public function testPostResetValid()
    {

        \Distilleries\Expendable\Models\Role::create([
            'libelle'            => 'admin',
            'initials'           => '@a',
            'overide_permission' => true,
        ]);

        \Distilleries\Expendable\Models\Service::create([
            'action' => 'test',
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => 1,
            'service_id' => 1,
        ]);


        $faker = Faker\Factory::create();
        $email = $faker->email;

        $user = \Distilleries\Expendable\Models\User::create([
            'email'    => $email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1
        ]);

        $response = \Illuminate\Support\Facades\Password::broker()->sendResetLink(['email' => $email]);
        $token    = \DB::table('password_resets')->where('email', $email)->get()->last();

        $this->call('POST', action('Backend\LoginController@postReset'), [
            'token'                 => $token->token,
            'email'                 => $token->email,
            'password'              => '_Example01!',
            'password_confirmation' => '_Example01!',
        ]);

        $this->assertRedirectedToAction('Backend\LoginController@getIndex');


    }*/

}

