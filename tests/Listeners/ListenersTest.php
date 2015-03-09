<?php

class ListenersTest extends ExpendableTestCase {


    public function testListenerDispatcherUserLoginWithRole()
    {

        \Distilleries\Expendable\Models\Role::create([
            'libelle'            => 'admin',
            'initials'           => '@a',
            'overide_permission' => false,
        ]);

        \Distilleries\Expendable\Models\Service::create([
            'action' => 'test',
        ]);

        $faker = Faker\Factory::create();

        \Distilleries\Expendable\Models\User::create([
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => 1,
        ]);

        \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => 1,
            'service_id' => 1,
        ]);

        global $firedTestListener;
        $firedTestListener = false;

        $listener = new TestListener();
        $listener->listen();

        new \Distilleries\Expendable\Events\UserEvent(\Distilleries\Expendable\Events\UserEvent::LOGIN_EVENT, \Distilleries\Expendable\Models\User::find(1));

        $this->assertEquals(true, $firedTestListener);
    }

    public function testListenerDispatcherUserLogin()
    {

        global $firedTestListener;
        $firedTestListener = false;

        $listener = new TestListener();
        $listener->listen();

        new \Distilleries\Expendable\Events\UserEvent(\Distilleries\Expendable\Events\UserEvent::LOGIN_EVENT, new \Distilleries\Expendable\Models\User);

        $this->assertEquals(true, $firedTestListener);
    }


    public function testListenerDispatcherUserLogout()
    {

        global $firedTestListener;
        $firedTestListener = false;

        $listener = new TestListener();
        $listener->listen();

        new \Distilleries\Expendable\Events\UserEvent(\Distilleries\Expendable\Events\UserEvent::LOGOUT_EVENT, new \Distilleries\Expendable\Models\User);

        $this->assertEquals(true, $firedTestListener);
    }


}


class TestListener extends \Distilleries\Expendable\Listeners\BaseListener {

    /**
     * @var array[
     * 'user.login'=>[
     *      'action'=>'handleLogin',
     *      'priority'=>0
     *  ]
     * ]
     *
     */
    protected $events = [
        'user.login'  => [
            'action'   => 'handleLogin',
            'priority' => 0,
        ],
        'user.logout' => [
            'action'   => 'handleLogOut',
            'priority' => 0,
        ]
    ];

    public function handleLogin($model)
    {
        global $firedTestListener;
        $firedTestListener = true;

    }

    public function handleLogOut()
    {
        global $firedTestListener;
        $firedTestListener = true;
    }
}