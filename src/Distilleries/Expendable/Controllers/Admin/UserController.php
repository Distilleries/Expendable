<?php

namespace Distilleries\Expendable\Controllers\Admin;

use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Controllers\AdminBaseComponent;
use Distilleries\Expendable\Controllers\AdminModelBaseController;
use Distilleries\Expendable\Datatables\User\UserDatatable;
use \User, \Auth;
use Distilleries\Expendable\Forms\User\UserForm;

class UserController extends AdminBaseComponent {

    public function __construct(User $model, StateDisplayerContract $stateProvider, UserDatatable $datatable, UserForm $form)
    {
        parent::__construct($model, $stateProvider);
        $this->datatable = $datatable;
        $this->form      = $form;
    }



    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    public function getProfile()
    {
        return $this->getEdit(Auth::administrator()->get()->getKey());
    }

    // ------------------------------------------------------------------------------------------------

    public function postProfile()
    {
        $this->postEdit();

        return $this->getProfile();
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


}