<?php

namespace Distilleries\Expendable\Contracts;

use Illuminate\Database\Eloquent\Model;

interface TranslatableObserverContract
{
    /**
     * Handle the model "deleting" event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function deleting(Model $model);
}
