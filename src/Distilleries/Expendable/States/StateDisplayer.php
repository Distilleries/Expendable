<?php namespace Distilleries\Expendable\States;

use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Illuminate\Contracts\View\Factory;

class StateDisplayer implements StateDisplayerContract {


    protected $states = [];
    protected $class = '';
    protected $view;
    public $config;

    public function __construct(Factory $view, array $config)
    {
        $this->view   = $view;
        $this->config = $config;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->states[] = $state;
    }

    // ------------------------------------------------------------------------------------------------

    /**
     * @param string $states
     */
    public function setStates($states)
    {
        $this->states = $states;
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    public function getRenderStateMenu($template = 'expendable::admin.form.state.menu')
    {
        return $this->view->make($template, [
            'states' => $this->getTableState(),
            'action' => '\\'.$this->class.'@'
        ]);
    }


    // ------------------------------------------------------------------------------------------------

    protected function getTableState()
    {
        $table  = [];
        $config = $this->config['state'];

        foreach ($this->states as $state)
        {

            if (in_array($state, array_keys($config)))
            {
                $table[] = $config[$state];
            }
        }

        $table = array_sort($table, function($value)
        {
            return $value['position'];
        });

        return $table;
    }
}