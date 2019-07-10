<?php namespace Distilleries\Expendable\Events;

use \Event;
use Distilleries\Expendable\Contracts\EventContract;

class EventDispatcher implements EventContract {

    protected $event_name;
    protected $params = array();


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    public function __construct($eventName, $params = array(), $auto_dispatch = true)
    {
        $this->event_name = $eventName;
        $this->params     = $params;

        if ($auto_dispatch === true)
        {
            $this->dispatch($this->params);
        }
    }

    // ------------------------------------------------------------------------------------------------

    /**
     * @inheritDoc
     */
    public function dispatch($params = array())
    {
        Event::dispatch($this->event_name, array($params));
    }

    /**
     * @param  array  $params
     * @deprecated Use dispatch instead
     */
    public function fire($params = array())
    {
        $this->dispatch($params);
    }
}