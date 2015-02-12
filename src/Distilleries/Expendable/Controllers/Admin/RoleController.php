<?php


namespace Distilleries\Expendable\Controllers\Admin;

use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Controllers\AdminBaseComponent;
use Distilleries\Expendable\Datatables\Role\RoleDatatable;
use \FormBuilder;
use Distilleries\Expendable\Forms\Role\RoleForm;


class RoleController extends AdminBaseComponent {

    public function __construct(\Role $model, StateDisplayerContract $stateProvider, RoleDatatable $datatable, RoleForm $form)
    {
        parent::__construct($model, $stateProvider);
        $this->datatable = $datatable;
        $this->form      = $form;
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


}