<?php namespace Distilleries\Expendable\Observers;

use \Request;
use \Hash;

class PasswordObserver {

    public function creating($model)
    {
        $this->hash($model, $model->password);
    }


    public function updating($model)
    {
        $newPassword = Request::get('password');

        if (empty($newPassword))
        {
            if (empty($model->password))
            {
                $newPassword = $model->find($model->id)->password;
            } else
            {
                $newPassword = $model->password;
            }

        }

        $this->hash($model, $newPassword);
    }


    public function hash($model, $password)
    {


        if (Hash::needsRehash($password))
        {
            $model->password = Hash::make($password);
        } else
        {
            $model->password = $password;
        }

    }
}