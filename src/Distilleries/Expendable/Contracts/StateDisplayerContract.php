<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 28/01/2015
 * Time: 11:25 AM
 */

namespace Distilleries\Expendable\Contracts;


interface StateDisplayerContract {

    public function setState($state);
    public function setStates($states);
    public function getRenderStateMenu($template='');

} 