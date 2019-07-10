<?php namespace Distilleries\Expendable\Contracts;

interface EventContract {

    /**
     * @param  array  $params
     * @return mixed
     */
    public function dispatch($params = array());
}