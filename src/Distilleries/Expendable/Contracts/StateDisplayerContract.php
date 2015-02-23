<?php namespace Distilleries\Expendable\Contracts;

interface StateDisplayerContract {

    public function setState($state);

    public function setStates($states);

    public function getRenderStateMenu($template = '');
}