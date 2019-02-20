<?php namespace Distilleries\Expendable\Listeners;

use \Event;
use Distilleries\Expendable\Contracts\ListenerContract;

class BaseListener implements ListenerContract {

    /**
     * @var array[
     * 'user.login'=>[
     *      'action'=>'handleLogin',
     *      'priority'=>0
     *  ]
     * ]
     *
     */
    protected $events = [];

    public function listen()
    {
        foreach ($this->events as $name => $event)
        {
            Event::listen($name, get_class($this).'@'.$event['action'], $event['priority']);
        }

    }
}