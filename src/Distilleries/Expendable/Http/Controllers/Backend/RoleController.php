<?php namespace Distilleries\Expendable\Http\Controllers\Backend;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Http\Datatables\Role\RoleDatatable;
use Distilleries\Expendable\Http\Forms\Role\RoleForm;
use Distilleries\Expendable\Http\Controllers\Backend\Base\BaseComponent;
use Distilleries\Expendable\Models\Role;

class RoleController extends BaseComponent {

    public function __construct(RoleDatatable $datatable, RoleForm $form, Role $model, LayoutManagerContract $layoutManager)
    {
        parent::__construct($model, $layoutManager);
        $this->datatable = $datatable;
        $this->form      = $form;
    }
}