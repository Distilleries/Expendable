<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 28/01/2015
 * Time: 11:26 AM
 */

namespace Distilleries\Expendable\Contracts;


interface FormStateContract {

    public function getEdit($id);
    public function postEdit();

} 