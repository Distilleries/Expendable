<?php

namespace Distilleries\Expendable\Controllers\Admin;

use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Controllers\AdminBaseComponent;
use Distilleries\Expendable\Controllers\AdminModelBaseController;
use Distilleries\Expendable\Datatables\Email\EmailDatatable;
use \Email;
use Distilleries\Expendable\Forms\Email\EmailForm;

class EmailController extends AdminBaseComponent {

    public function __construct(Email $model, StateDisplayerContract $stateProvider, EmailDatatable $datatable, EmailForm $form)
    {
        parent::__construct($model, $stateProvider);
        $this->datatable = $datatable;
        $this->form      = $form;
    }



    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


}