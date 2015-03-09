<?php

class EventsTest extends ExpendableTestCase {

    public function testEventDispatcherUserLogin()
    {

        Event::listen('user.login', function ($model)
        {
            $this->assertInstanceOf('Distilleries\Expendable\Models\User', $model);
        }, 0);


        new \Distilleries\Expendable\Events\UserEvent(\Distilleries\Expendable\Events\UserEvent::LOGIN_EVENT, new \Distilleries\Expendable\Models\User);


    }

    public function testEventDispatcherUserLogout()
    {

        global $fired;
        $fired = false;
        Event::listen('user.logout', function ($model)
        {
            global $fired;
            $fired = true;
            $this->assertInstanceOf('Distilleries\Expendable\Models\User', $model);
        }, 0);


        new \Distilleries\Expendable\Events\UserEvent(\Distilleries\Expendable\Events\UserEvent::LOGOUT_EVENT, new \Distilleries\Expendable\Models\User);

        $this->assertEquals(true, $fired);

    }

    public function testEventDispatcherNoAutoDispatch()
    {
        global $fired;
        $fired = false;
        Event::listen('user.logout', function ($model)
        {
            global $fired;
            $fired = true;
            $this->assertEquals('test', $model);
        }, 0);


        $event = new \Distilleries\Expendable\Events\UserEvent(\Distilleries\Expendable\Events\UserEvent::LOGOUT_EVENT, new \Distilleries\Expendable\Models\User, false);
        $this->assertEquals(false, $fired);
        $event->fire('test');
        $this->assertEquals(true, $fired);
    }

}