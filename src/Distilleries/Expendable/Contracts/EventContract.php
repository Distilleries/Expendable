<?php namespace Distilleries\Expendable\Contracts;

interface EventContract {

    public function fire($params = array());
}