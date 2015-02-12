<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 27/01/2015
 * Time: 12:19 PM
 */

namespace Distilleries\Expendable\Contracts;


interface EventContract {

    public function fire($params = array());

} 